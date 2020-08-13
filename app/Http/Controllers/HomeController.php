<?php

namespace App\Http\Controllers;

use App\Category;
use App\LineItem;
use App\MarkupSetting;
use App\Option;
use App\Payment;
use App\PaymentHistory;
use App\Product;
use App\ProductCategory;
use App\ProductDeleteHistory;
use App\ProductImage;
use App\ProductImportHistory;
use App\ProductLocation;
use App\ProductVariants;
use App\RetailerOrder;
use App\RetailerProduct;
use App\RetailerProductImage;
use App\RetailerProductOption;
use App\RetailerProductVariant;
use App\SupplierOrder;
use App\SupplierOrderFulfillment;
use App\SupplierOrderLineItem;
use App\SupplierSetting;
use App\SupplierStores;
use App\User;
use App\UserProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription;
use OhMyBrew\ShopifyApp\Facades\ShopifyApp;
use OhMyBrew\ShopifyApp\Models\Shop;
use Stripe\PaymentMethod;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $categories = Category::all();

        $total_revenue = 0;
        $current_month_revenue = 0;
        $last_month_revenue = 0;
        $total_profit = 0;
        $current_month_profit = 0;
        $currentMonth = date('m');
        $lastMonth = Carbon::now()->subMonth()->format('m');
        $start_date = Carbon::today();
        $end_date = Carbon::today()->subDays(30);

        if ($user->hasRole('admin')) {
            $productsCount = Product::where('supplier_id', '!=', null)->count();

        } else {
            $productsCount = Product::where('supplier_id', $user->id)->count();
        }
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $ordersCount = SupplierOrder::count();
            $suppliers = User::role('supplier')
                ->orderBy('created_at', 'desc')->get()->take(5);
            $retailers = User::role('retailer')
                ->orderBy('created_at', 'desc')->get()->take(5);

            return view('admin.dashboard')->with([
                'productsCount' => $productsCount,
                'categories' => $categories,
                'suppliers' => $suppliers,
                'retailers' => $retailers,
                'ordersCount' => $ordersCount
            ]);
        }
        //retailer dashboard
        if ($user->hasRole('retailer')) {
            //check if markup settings available

            $markup_settings = MarkupSetting::where('user_id', $user->id)->first();

            if ($markup_settings == null) {
                $markup_settings = new MarkupSetting();
                $markup_settings->ask_every_time = true; //by default it will ask for profit margin every time you import product
                $markup_settings->user_id = $user->id;
                $markup_settings->save();
            }

            //for order count
            $orders = RetailerOrder::where('retailer_id', Auth::id())->get();
            $ordersCount = 0;

            foreach ($orders as $order) {
                $line_items = $order->hasLineItems;
                foreach ($line_items as $line_item) {
                    //gives retailer variant
                    $linked_retailer_product_variant = $line_item->linked_retailer_product_variant;

                    if ($linked_retailer_product_variant != null) {
                        Log::error('product imported from our system');
                        $ordersCount++;
                        break;
                    }
                }
            }

            $retailer_orders = RetailerOrder::where('retailer_id', Auth::id())->get();
            $current_month_orders = RetailerOrder::where('retailer_id', Auth::id())->whereRaw('MONTH(created_at) = ?', [$currentMonth])
                ->get();
            $last_month_orders = RetailerOrder::where('retailer_id', Auth::id())->whereRaw('MONTH(created_at) = ?', [$lastMonth])
                ->get();

            $current_month_revenue = 0;
            $last_month_revenue = 0;
            $total_profit = 0;
            $current_month_profit = 0;

            //total revenue
            $total_revenue = RetailerOrder::where('retailer_id', Auth::id())->get()->sum('total_price');

            //current month revenue
            $current_month_revenue = $current_month_orders->sum('total_price');

            //last month revenue
            $last_month_revenue = $last_month_orders->sum('total_price');

            //total profit

            foreach ($retailer_orders as $retailer_order) {
                $line_items =  $retailer_order->hasLineItems;
                foreach ($line_items as $line_item) {
                    if($line_item->linked_retailer_product_variant != null){
                        $total_profit = $total_profit + (($line_item->linked_retailer_product_variant->price - $line_item->linked_retailer_product_variant->cost) * $line_item->quantity);

                    }
                }
            }

            $productsCount = RetailerProduct::where('retailer_id', Auth::id())
                ->where('toShopify', true)
                ->count();

            return view('admin.dashboard')->with([
                'productsCount' => $productsCount,
                'ordersCount' => $ordersCount,
                'categories' => $categories,
                'total_profit' => $total_profit,
                'current_month_revenue' => $current_month_revenue,
                'last_month_revenue' => $last_month_revenue,
                'total_revenue' => $total_revenue
            ]);
        } else if ($user->role('supplier')) {
            $supplier_settings = SupplierSetting::where('supplier_id', $user->id)->first();

            if ($supplier_settings == null) {
                $supplier_settings = new SupplierSetting();
                $supplier_settings->supplier_id = $user->id;
                $supplier_settings->shipping_price = 0;
                $supplier_settings->shipping_estimate = 0;
                $supplier_settings->save();
            }

            $orders = RetailerOrder::all();
            $ordersCount = 0;
            $storesCount = $user->stores()->count();

            foreach ($orders as $order) {
                $supplier_products_array = [];
                if ($order->send_to_supplier) {
                    $order_line_items = $order->hasLineItems;
                    $hasSupplierProducts = false;
                    foreach ($order_line_items as $line_item) {

                        //check if line item has linking product variant
                        if ($line_item->retailer_product_variant_id != null) {
                            //yes this product is from our database
                            $retailer_variant = RetailerProductVariant::find($line_item->retailer_product_variant_id);

                            //check if we have variant of this product exists in our database
                            if ($retailer_variant != null) {
                                //yes we have this product variant in out database
                                $retailer_product = RetailerProduct::find($retailer_variant->retailer_product_id);
                                $retailer = User::find($retailer_product->retailer_id)->name;
                                $supplier_product = Product::find($retailer_product->product_id);

                                //check if the supplier still has this product
                                if ($supplier_product != null) {
                                    //yes the supplier still have this product
                                    $supplier = User::find(UserProduct::where('product_id', $supplier_product->id)->first()->user_id);
                                    if ($supplier->id == Auth::id()) {
                                        $ordersCount++;
                                    }
                                } else {
                                    //no the supplier does not have this product

                                    $deleted_product_json = ProductDeleteHistory::where('product_id', $retailer_product->product_id)->first();

                                    //check product if product is deleted by supplier
                                    if ($deleted_product_json != null) {
                                        //yes this product is from deleted ones
                                        $deleted_product = json_decode($deleted_product_json->product);
                                        $supplier = User::find($deleted_product->products->supplier_id);

                                        //check if we still have the data of this product's supplier
                                        if ($supplier != null) {
                                            //yes we sill have the supplier's data
                                            //check if the current logged in user is the actual supplier of this product
                                            if ($supplier->id == Auth::id()) {
                                                //yes logged in user is the supplier of this product
                                                $ordersCount++;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    //check if we have any order which contains the product of current logged in user
                    if ($hasSupplierProducts) {
                        // yes we have some
                        array_push($orders_array, [
                            'retailer' => $order->has_retailer->name,
                            'order' => $order,
                            'supplier_products' => $supplier_products_array
                        ]);
                    }
                }
            }


            $total_orders = SupplierOrder::where('supplier_id', Auth::id())->get();
            $current_month_orders = SupplierOrder::where('supplier_id', Auth::id())->whereRaw('MONTH(created_at) = ?', [$currentMonth])
                ->get();
            $last_month_orders = SupplierOrder::where('supplier_id', Auth::id())->whereRaw('MONTH(created_at) = ?', [$lastMonth])
                ->get();


            //calculating revenue from the orders of all time
            foreach ($total_orders as $supplier_order) {
                $line_items = $supplier_order->hasLineItems;
                foreach ($line_items as $line_item) {
                    if($line_item->retailer_product_variant != null){
                    if ($line_item->fulfilled_quantity == $line_item->quantity) {
                        $total_revenue = $total_revenue + (ProductVariants::where('title', $line_item->retailer_product_variant->title)->first()->price * $line_item->quantity);
                        }
                        $total_profit = $total_profit + ((ProductVariants::where('title', $line_item->retailer_product_variant->title)->first()->price - ProductVariants::where('title', $line_item->retailer_product_variant->title)->first()->cost) * $line_item->quantity);
                    }
                    }
                }
            }

            //calculating revenue from the orders of current month
            foreach ($current_month_orders as $supplier_order) {
                $line_items = $supplier_order->hasLineItems;
                foreach ($line_items as $line_item) {
                    if($line_item->retailer_product_variant != null){
                    if ($line_item->fulfilled_quantity == $line_item->quantity) {
                        $current_month_revenue = $current_month_revenue + (ProductVariants::where('title', $line_item->retailer_product_variant->title)->first()->price * $line_item->quantity);
                    }
                    $current_month_profit = $current_month_profit + (ProductVariants::where('title', $line_item->retailer_product_variant->title)->first()->price - ProductVariants::where('title', $line_item->retailer_product_variant->title)->first()->cost);
                }
                }

            }

            //last month revenue
            foreach ($last_month_orders as $supplier_order) {
                $line_items = $supplier_order->hasLineItems;
                foreach ($line_items as $line_item) {
                    if($line_item->retailer_product_variant != null) {
                        if ($line_item->fulfilled_quantity == $line_item->quantity) {
                            $last_month_revenue = $last_month_revenue + (ProductVariants::where('title', $line_item->retailer_product_variant->title)->first()->price * $line_item->quantity);
                        }
                    }
                }
            }
        $roles = $user->getRoleNames();
        dd($roles);

            return view('admin.dashboard')->with([
                'productsCount' => $productsCount,
                'storesCount' => $storesCount,
                'categories' => $categories,
                'ordersCount' => $ordersCount,
                'total_revenue' => $total_revenue,
                'total_profit' => $total_revenue,
                'current_month_revenue' => $current_month_revenue,
                'current_month_profit' => $current_month_profit,
                'last_month_revenue' => $last_month_revenue
            ]);
        }


    public function permissions()
    {

        $user = Auth::user();
        $permissions = $user->getAllPermissions();

        dd($permissions);
    }

    public function role()
    {
        $user = Auth::user();

        $roles = $user->getRoleNames();
        dd($roles);
    }

    public function bari_command()
    {
        Artisan::call('optimize');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('optimize:clear');
        Artisan::call('route:clear');

        return "Bari command successfully executed";
    }
    public function updateSupplierInfo(Request $request){

        $user = User::find($request->input('supplier_id'));
        if($request->input('type') == 'user'){
            $user->name = $request->input('name');
            $user->company_name = $request->input('company_name');
        }
        else{
            $user->address = $request->input('address1');
            $user->address2 = $request->input('address2');
            $user->city = $request->input('city');
            $user->state = $request->input('state');
            $user->country = $request->input('country');
        }

        $user->save();
        return redirect()->back()->with([
            'success' => 'Account Information Updated!'
        ]);
    }

    public function updateAdminInfo(Request $request){

        $user = User::find($request->input('admin_id'));
        if ($request->hasFile('profile')) {
            $imageFile = $request->file('profile');
            $imageName = substr(Str::slug($imageFile->getClientOriginalName()), 0, -3) . '.' . $imageFile->getClientOriginalExtension();
            $path = public_path() . '/images/admin/';
            $imageFile->move($path, $imageName);
            $user->gender = '/images/admin/' . $imageName;
            $user->save();
        }

        $user->name = $request->input('name');
        $user->save();

        if(User::where('email',$request->input('email'))->exists()){
            return redirect()->back()->with([
                'success' => 'Account Information Updated! But Email Cant Update Due to Duplication'
            ]);
        }
        else{
            $user->email =  $request->input('email');
            $user->save();
        }
        return redirect()->back()->with([
            'success' => 'Account Information Updated!'
        ]);
    }

    public function updateSupplierPassword(Request $request){
        if(Auth::validate($request->except(['new-pw','new-pwr','supplier_id','_token']))){
            $authenticate = true;
        }
        else{
            $authenticate = false;
        }
        if($authenticate){
            $user = User::find($request->input('supplier_id'));
            $user->password = Hash::make($request->input('new-pw'));
            $user->save();
            return redirect()->back()->with([
                'success' => 'Password Changed Successfully'
            ]);
        }
        else{
            return redirect()->back()->with([
                'error' => 'Your Entered Current Password Went Invalid'
            ]);
        }

    }

    public function settings_page()
    {
        $user = Auth::user();
        $markup_settings = MarkupSetting::where('user_id', $user->id)->first();

        if ($markup_settings == null) {
            $markup_settings = new MarkupSetting();
            $markup_settings->type = null;
            $markup_settings->value = null;
            $markup_settings->user_id = $user->id;
            $markup_settings->ask_every_time = 1;
            $markup_settings->save();
        }

        if ($user->hasRole('supplier')) {
            $supplier_settings = SupplierSetting::where('supplier_id', $user->id)->first();



            if ($supplier_settings == null) {
                $supplier_settings = new SupplierSetting();
                $supplier_settings->supplier_id = $user->id;
                $supplier_settings->shipping_price = 0;
                $supplier_settings->shipping_estimate = 0;
                $supplier_settings->save();
            }
//            $payment_method = Payment::where('user_id', $user->id)
//             ->first();
//            $invoices = \auth()->user()->invoices();
            $shops = Shop::all();
            $user = \auth()->user();
            if($user->referral_code == null){
                $code = '___'.rand(66,979878).str_replace(' ','',$user->email).'_____'.rand(65465,223232223);
                $user->referral_code =$code;
                $user->save();
            }

            return view('settings.index')->with([
                'supplier_settings' => $supplier_settings,
                'markup_settings' => $markup_settings,
//                'payment_method' => $payment_method
                'intent' => auth()->user()->createSetupIntent(),
                'monthly_subscribption_key' => 'plan_GqXTaQ1tU0rNlq',
                'user' => $user,
//                'invoices' =>$invoices,
                'shops' => $shops
            ]);

        } else if ($user->hasRole('retailer')) {
            $shop = ShopifyApp::shop();
            $payment_method = Payment::where('user_id', $user->id)
                ->get();

            return view('settings.index')->with([
                'markup_settings' => $markup_settings,
                'payment_method' => $payment_method,
                'shop' => $shop
            ]);
        }
        else if ($user->hasRole('admin')){
            return view('settings.index')->with([
                'user' => $user,
            ]);
        }


    }

    public function supplier_subscribe(Request $request){
//        dd($request);
        $user = auth()->user();
        $paymentMethod = $request->input('payment_method');
        $planId = $request->input('plan');
        $user->newSubscription('Supplier Monthly Plan - SmokeDrop', $planId)->create($paymentMethod);
        $user->address = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->zip = $request->input('zip');
        $user->save();
        return response()->json([
            'message'=>'success'
        ]);
    }
    public function supplier_set_subscription(Request $request){
        if($request->input('action') == 'cancel'){
            \auth()->user()->subscription('Supplier Monthly Plan - SmokeDrop')->cancelNow();
            return response()->json([
                'status' => 'success',
                'message' => 'Subscription '.$request->input('action').'led Successfully'
            ]);
        }
        else{
            \auth()->user()->subscription('Supplier Monthly Plan - SmokeDrop')->resume();
            return response()->json([
                'status' => 'success',
                'message' => 'Subscription '.$request->input('action').'d Successfully'
            ]);
        }

    }
    public function set_restrictions(Request $request){

//        dd($request);
//        $user = Auth::user();
//        if($request->input('selection') == 'selected'){
//            $user->restricted_stores()->sync($request->input('restricted'));
//        }
//        else{
//            $user->restricted_stores()->sync([]);
//        }
//        return redirect()->back()->with([
//           'success' => 'Store Preferences Updated!'
//        ]);

        $shop = Shop::find($request->input('shop_id'));
        $supplier = User::where('referral_code',$request->input('code'))->first();
        $shop->attached_suppliers()->attach([$supplier->id]);
        return redirect()->back()->with([
           'success' => 'Referral Supplier Attached Successfully!'
        ]);

    }
    public function detach_store_supplier (Request $request){
        $shop = Shop::find($request->store_id);
        $supplier = User::find($request->supplier_id);
        $shop->attached_suppliers()->detach([$supplier->id]);
        return redirect()->back()->with([
            'success' => 'Referral Detached Successfully!'
        ]);
    }

    public function reset_all(){
        LineItem::truncate();
        MarkupSetting::truncate();
        Option::truncate();
        Payment::truncate();
        PaymentHistory::truncate();

        ProductCategory::truncate();
        ProductDeleteHistory::truncate();
        $images  = ProductImage::all();
        foreach ($images as $image){
            $image->forceDelete();
        }
        ProductVariants::truncate();
        ProductImportHistory::truncate();
        ProductLocation::truncate();


        RetailerOrder::truncate();
        RetailerProductVariant::truncate();
        $images =  RetailerProductImage::all();
        foreach ($images as $image){
            $image->forceDelete();
        }
        RetailerProductOption::truncate();

        $shops = Shop::all();
        foreach ($shops as $shop){
            $shop->forceDelete();
        }

        DB::table('shop_supplier')->truncate();
        Subscription::truncate();

        SupplierOrderLineItem::truncate();
        SupplierOrderFulfillment::truncate();
        SupplierStores::truncate();
        SupplierSetting::truncate();
        SupplierOrder::truncate();

        $retailers_products = RetailerProduct::all();
        foreach ($retailers_products as $retailers_product){
            $retailers_product->forceDelete();
        }
        DB::table('user_products')->truncate();
        $products = Product::all();
        foreach ($products as $product){
            $product->forceDelete();
        }


        $users = User::all();
        foreach ($users as $user){
            if($user->email == 'admin@admin.com'){

            }
            else{
                $user->syncRoles([]);
                $user->delete();
            }
        }
        echo 'Database Clear Successfully!';
    }

}
