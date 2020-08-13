<?php

namespace App\Http\Controllers;

use App\Category;
use App\MarkupSetting;
use App\Product;
use App\ProductCategory;
use App\ProductImage;
use App\RetailerOrder;
use App\SubCategory;
use App\SupplierOrder;
use App\SupplierSetting;
use App\SupplierStores;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OhMyBrew\ShopifyApp\Models\Shop;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-view|product-create|product-edit|product-delete', ['only' =>
            ['showProducts', 'dashboard']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function showProducts(Request $request)
    {
        return redirect('/products');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function manageProducts()
    {
        $products = Product::paginate(30);
        $categories = Category::all();

        return view('products.add_category', compact('products', 'categories'));
    }

    public function subcategories($id)
    {
        $subcategories = SubCategory::where('category_id', $id)->get();

        return [
            'status' => 200,
            'data' => $subcategories
        ];
    }

    public function assignProducts(Request $request)
    {
        $products_string = $request->input('products');
        $sub_category_id = $request->input('sub_category');
//        $category_id = $request->input('category');

        $products_array = [];

        //convert string into array
        $temp = '';
        for ($i = 0; $i < strlen($products_string); $i++) {
            if ($products_string[$i] != ',') {
                $temp = $temp . $products_string[$i];

                if ($i == strlen($products_string) - 1) {
                    array_push($products_array, $temp);
                    $temp = '';
                }
            } else {
                array_push($products_array, $temp);
                $temp = '';
            }
        }

        foreach ($products_array as $product_id) {
            $checkIfProductAlreadyExistsInSameSubCategory = ProductCategory::where('product_id', $product_id)
                ->where('sub_category_id', $sub_category_id)->first();

            if ($checkIfProductAlreadyExistsInSameSubCategory == null) {
                $product_category = new ProductCategory();
                $product_category->product_id = $product_id;
                $product_category->sub_category_id = $sub_category_id;
                $product_category->save();
            }

        }

        return back()->with('success', 'Category has been assigned to selected products successfully.');
    }

    public function deAssignProducts(Request $request)
    {

        $product_id = $request->input('product_id');
        $sub_category_id = $request->input('sub_category_id');

        $pivot = ProductCategory::where('product_id', $product_id)->where('sub_category_id', $sub_category_id)->first()->delete();

        if ($pivot) {
            return back()->with('success', 'Category has been de assigned successfully.');
        } else {
            return back()->with('error', 'Unable to de assigned category.');
        }

    }

    public function stores()
    {
        $supplier_stores = SupplierStores::paginate(30);
        return view('store.index', compact('supplier_stores'));
    }

    public function orders(Request $request)
    {
        $orders = SupplierOrder::Query();
        if($request->has('filter-by-supplier')){
           $orders->whereHas('supplier',function ($q) use ($request){
             $q->where('name','LIKE','%'.$request->input('filter-by-supplier').'%');
           });
        }
        if($request->has('filter-by-store')){
           $stores_id = User::role('retailer')->where('name','LIKE','%'.$request->input('filter-by-store').'%')->pluck('id')->toArray();
           $retailer_orders_id = RetailerOrder::whereIN('retailer_id',$stores_id)->pluck('id')->toArray();
           $orders->whereIN('retailer_order_id',$retailer_orders_id);
        }
        if($request->has('filter-by-status')){
            if($request->input('filter-by-status') == 'pending'){
                $orders->whereNull('fulfillment_status');
            }
            else if($request->input('filter-by-status') == 'ordered'){
                $orders->where('fulfillment_status','fulfilled');
            }
            else if($request->input('filter-by-status') == 'shipped'){
                $orders->whereHas('fulfillments',function ($q) use ($request){
                    $q->where('tracking_number','!=',"");
                });
            }
            else{

            }
        }

        $orders = $orders->paginate(30);

        return view('orders.index')->with([
            'orders' => $orders,
            'queryStore' =>$request->input('filter-by-store'),
            'queryStatus' =>$request->input('filter-by-status'),
            'querySupplier' =>$request->input('filter-by-supplier'),
            'stores' => User::role('retailer')->get(),
            'suppliers' => User::role('supplier')->get(),
        ]);
    }

    public function retailers(Request $request)
    {
        $retailers = User::role('retailer')->newQuery();
        if($request->has('filter-by-name')){
            $retailers->where('name','LIKE','%'.$request->input('filter-by-name').'%');
        }

        $retailers = $retailers->paginate(30);
        $queryName = $request->input('filter-by-name');
        $pageType = 'retailer-page';

        return view('users.index', compact('retailers','pageType','queryName'));
    }

    public function suppliers(Request $request)
    {
        $suppliers = User::role('supplier')->newQuery();
        if($request->has('status')){
            if($request->input('status') == 'all'){}
            else{
                if($request->input('status') == 'active'){
                    $suppliers->where('status',1);
                }
                else{
                    $suppliers->where('status',0);
                }
            }

        }
        if($request->has('filter-by-supplier')){
            $suppliers->where('name','LIKE','%'.$request->input('filter-by-supplier').'%');
        }
        $suppliers = $suppliers->paginate(30);
        $querySupplier = $request->input('filter-by-supplier');
        $queryStatus = $request->input('status');
        $pageType = 'supplier-page';
        return view('users.index', compact('suppliers','querySupplier','queryStatus','pageType'));
    }

    public function retailer(Request $request,$id)
    {
        $retailer = User::find($id);
        $shop = Shop::where('shopify_domain',$retailer->name.'.myshopify.com')->first();
        $retailer_orders = $retailer->retailer_orders;
//        dd($retailer_orders[0]->transactions);
        $retailer_markup_settings = MarkupSetting::whereUserId($id)->first();
        $retailer_products = $retailer->retailer_products()->orderBy('created_at', 'desc')->newQuery();
        if($request->has('filter-by-name')) {
            $retailer_products->where('title', 'LIKE', '%' . $request->input('filter-by-name') . '%');
        }
        $retailer_products = $retailer_products->get();

        $queryName = $request->input('filter-by-name');
        return view('users.show')->with([
            'shop' =>$shop,
            'retailer' => $retailer,
            'retailer_products' => $retailer_products,
            'retailer_orders' => $retailer_orders,
            'retailer_markup_settings' => $retailer_markup_settings,
            'queryName' =>$queryName,
        ]);
    }

    public function supplier(Request $request,$id)
    {
        $supplier = User::find($id);

        $supplier_orders = $supplier->supplier_orders->sortByDesc('created_at');
        $supplier_products = $supplier->products()->orderBy('created_at', 'desc')->newQuery();
        if($request->has('filter-by-name')) {
            $supplier_products->where('title', 'LIKE', '%' . $request->input('filter-by-name') . '%');
        }
        if($request->has('filter-by-status')){
            if($request->input('filter-by-status') == 'active'){
                $supplier_products->where('status',true);
            }
            else if($request->input('filter-by-status') == 'disabled')
                $supplier_products->where('status',false);
        }
        $supplier_products = $supplier_products->paginate(15);
        $supplier_stores = $supplier->stores;
        $supplier_markup_settings = MarkupSetting::whereUserId($id)->first();
        $supplier_settings = SupplierSetting::whereSupplierId($id)->first();


        $queryStatus = $request->input('filter-by-status');

        $queryName = $request->input('filter-by-name');

        return view('users.show')->with([
            'supplier' => $supplier,
            'supplier_orders' => $supplier_orders,
            'supplier_stores' => $supplier_stores,
            'supplier_settings' => $supplier_settings,
            'supplier_markup_settings' => $supplier_markup_settings,
            'supplier_products' => $supplier_products,
            'queryName' =>$queryName,
            'queryStatus' =>$queryStatus,
        ]);
    }

    public function changeProductStatus(Request $request, $product_id)
    {
        $product = Product::find($product_id);

        if ($request->input('status') == 'on') {
            $product->status = 1;
        } else {
            $product->status = 0;
        }

        $product->save();

        return back()->with('success', 'Product status has been updated successfully');
    }

    public function changeSupplierStatus(Request $request,$supplier_id){
        $supplier = User::find($supplier_id);
//        dd($supplier);
        if ($request->input('status') == 'on') {
            $supplier->status = 1;
        } else {
            $supplier->status = 0;
        }

        $supplier->save();

        return back()->with('success', 'Supplier status has been updated successfully');
    }

    public function orders_with_details($id)
    {
        $order = SupplierOrder::find($id);
        $order_with_details = [];
//        foreach ($orders as $index => $order) {

//            dd($order->hasLineItems);
            \Debugbar::info(json_encode($order->hasLineItems));
            $orderDetails = [
                'order' => $order->retailer_order,
                'order_details' => $order->hasLineItems
            ];
            array_push($order_with_details, $orderDetails);
//        }
//        dd($order_with_details);
        $pageType = 'admin';
//        dd($order_with_details);
        return view('orders.index_detailed')->with([
            'order_with_details' => $order_with_details,
            'pageType' => $pageType
        ]);
    }

    public function payments(Request $request){
        $suppliers = User::role('supplier')->get();
        $retailers = User::role('retailer')->get();
        return view('payments.admin.index')->with([
           'suppliers' => $suppliers,
           'retailers' => $retailers
        ]);
    }

    public function reset_show(Request $request){
        return view('payments.reset.index');
    }

    public function trail_extension(Request $request,$supplier_id){
        $supplier = User::find($supplier_id);
        if($request->has('trial_ends_at')){
            $supplier->trial_ends_at = $request->input('trial_ends_at');
            $supplier->save();
        }
        return back()->with('success', 'Supplier Trial Extension has been updated successfully');
    }

    public function FreeUserStatus(Request $request,$supplier_id){
        $supplier = User::find($supplier_id);

            if ($request->input('free_user') == 'on') {
                $supplier->free_user = 1;
            } else {
                $supplier->free_user = 0;
            }
            $supplier->save();

        return back()->with('success', 'Supplier Free-User-Subscription has been updated successfully');
    }
}
