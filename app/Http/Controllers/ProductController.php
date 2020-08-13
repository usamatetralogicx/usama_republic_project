<?php

namespace App\Http\Controllers;

use App\Category;
use App\MarkupSetting;
use App\Option;
use App\Product;
use App\ProductDeleteHistory;
use App\ProductImage;
use App\ProductVariants;
use App\RetailerProduct;
use App\SubCategory;
use App\SupplierStores;
use App\User;
use App\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use OhMyBrew\ShopifyApp\ShopifyApp;
use function foo\func;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-view|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $user = Auth::user();
        $products = [];
        $pageType = '';
        $selected_category = '';
//        dd(Auth::user()->getRoleNames());

        if ($user->hasRole('supplier')) {
            if($request->has('search')){
                $products =Product::where('supplier_id', $user->id)
                    ->where('status', true)->newQuery();
                if (request('category-filter')) {
                    $category = urldecode(request('category-filter'));
                    $selected_category = Category::whereName($category)->first();

                    if ($selected_category != null) {
                        $sub_categories = $selected_category->sub_categories;

                        $products->whereHas('sub_categories', function ($q) use ($selected_category, $request) {
                            return $q->where('category_id', $selected_category->id);
                        });
                    }
                }
                if (request('search')) {
                    $products->when(request('search') != null, function ($q) {
                        $q->where('title', 'like', '%' . request('search') . '%');
                        $q->orWhere('body_html', 'like', '%' . request('search') . '%');
                        return $q;

                    });
                }
                if (request('store-filter')) {
                    $products->whereHas('has_store', function ($q) use ( $request) {
                        return $q->where('shop_domain', request('store-filter'));
                    });
                }
                $products = $products->paginate(30);

            }
            else{
                $products = Product::where('supplier_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(30);
            }

        } else {
            if ($request->has('products')) {
                if ($request->input('products') == 'disabled') {
                    $products = Product::latest()
                        ->where('supplier_id', '!=', null)
                        ->where('status', false)
                        ->paginate(30);
                    $pageType = 'disabled products';
                }
                else if($request->input('products') == 'active'){
                    $products = Product::latest()
                        ->where('supplier_id', '!=', null)
                        ->where('status', true)
                        ->paginate(30);
                    $pageType = 'active products';
                }
            }
            else {
                if($request->has('filter-by-supplier') && $request->has('filter-by-status')){
                    $products = Product::latest()
                        ->where('supplier_id', '!=', null)->newQuery();
                    if($request->has('filter-by-name')) {
                        $products->where('title', 'LIKE', '%' . $request->input('filter-by-name') . '%');
                    }
                    if($request->has('filter-by-supplier')){
                        $products->whereHas('linked_supplier',function($query) use ($request){
                            $query->where('name','LIKE','%'.$request->input('filter-by-supplier').'%');
                        });
                    }
                    if($request->has('filter-by-status')){
                        if($request->input('filter-by-status') == 'active'){
                            $products->where('status',true);
                        }
                        else if($request->input('filter-by-status') == 'disabled')
                            $products->where('status',false);
                    }

                    $products = $products->paginate(30);
                }
                else{
                    $products = Product::latest()
                        ->where('supplier_id', '!=', null)
                        ->paginate(30);
                }
                $pageType = 'all products';
            }
        }
        $search = null;
        if (request('search')) {
            $search = request('search');
        }
        $selected_store = null;
        if (request('store-filter')) {
            $selected_store = request('store-filter');
        }


        $product_images = ProductImage::all();
        $categories = Category::all();
        $querySupplier = $request->input('filter-by-supplier');
        if ($request->has('products')) {
            $queryStatus = $request->input('products');
        }
        else{
            $queryStatus = $request->input('filter-by-status');
        }
        $queryName = $request->input('filter-by-name');

        $suppliers = User::role('supplier')->get();


        return view('products.index', compact('products', 'categories', 'product_images', 'pageType','selected_category','search','selected_store','queryStatus','querySupplier','suppliers','queryName'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }

    public function productsByCategory($id)
    {
        $selected_category = Category::find($id);
        $categories = Category::all();
        //retailer and admin can see all products of all categories
        $sub_categories = SubCategory::where('category_id', $id)->get();
        $products = [];

        foreach ($sub_categories as $sub_category) {
            $products_with_this_sub_category = $sub_category->products;

            foreach ($products_with_this_sub_category as $single_product) {
                array_push($products, $single_product);
            }
        }

//        dd($products);
        $paginate = false;

        if (Auth::user()->hasRole('retailer')) {
            $retailer_products = RetailerProduct::where('retailer_id', Auth::id())->pluck('product_id')->toArray();
            $vendors_array = Product::where('vendor', '!=', '')->distinct()->pluck('vendor')->toArray();
            $vendors = [];
            foreach ($vendors_array as $vendor) {
                array_push($vendors, [
                    'vendor' => $vendor,
                    'product_count' => Product::where('vendor', $vendor)->count()
                ]);
            }
            return view('products.search_products', compact('retailer_products', 'selected_category', 'products', 'sub_categories', 'paginate', 'categories', 'vendors'
            ));
        }
        return view('products.search_products', compact('selected_category', 'products', 'sub_categories',
            'paginate', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create')->with([
            'categories' =>$categories
        ]);
    }

    //to save manually added products
    public function store(Request $request)
    {

        request()->validate([
            'title' => 'required',
        ]);


        $product = new Product();
        $product->title = $request->input('title');
        $product->body_html = $request->input('body_html');
        $product->fromShopify = false;
        $product->cost = $request->input('cost');
        $product->price = $request->input('price');
        $product->sku = $request->input('sku');
        $product->vendor = $request->input('vendor');
        $product->grams = $request->input('grams');

        if ($request->input('option1') != null) {
            $product->option1 = $request->input('option1');
            $values_arr = explode(",", $request->input('value1'));
            $product->value1 = json_encode($values_arr);
        }
        if ($request->input('option2') != null) {
            $product->option2 = $request->input('option2');
            $values_arr = explode(",", $request->input('value2'));
            $product->value2 = json_encode($values_arr);
        }
        if ($request->input('option3') != null) {
            $product->option3 = $request->input('option3');
            $values_arr = explode(",", $request->input('value3'));
            $product->value3 = json_encode($values_arr);
        }

        $product->type = $request->input('type');
        $product->tags = $request->input('tags');

        $product->save();
        if($request->has('subcategory')){
            $product->sub_categories()->attach($request->input('subcategory'));
        }

        if ($request->input('option1') != null) {
            $option1 = new Option();
            $option1->product_id = $product->id;
            $option1->name = $request->input('option1');
            $option1->position = 1;
            $values_arr = explode(",", $request->input('value1'));
            $option1->values = json_encode($values_arr);
            $option1->save();
        }
        if ($request->input('option2') != null) {
            $option2 = new Option();
            $option2->product_id = $product->id;
            $option2->name = $request->input('option2');
            $option2->position = 2;
            $values_arr = explode(",", $request->input('value2'));
            $option2->values = json_encode($values_arr);
            $option2->save();
        }
        if ($request->input('option3') != null) {
            $option3 = new Option();
            $option3->product_id = $product->id;
            $option3->name = $request->input('option3');
            $option3->position = 3;
            $values_arr = explode(",", $request->input('value3'));
            $option3->values = json_encode($values_arr);
            $option3->save();
        }

        if ($request->has('images')) {
            if ($product->image != null || $product->image != '') {
                unlink(public_path() . $product->image);
            }
            //saving file

            $filesCount = count($request->file('images'));

            if ($filesCount > 0) {
                for ($i = 0; $i < $filesCount; $i++) {
                    $product_image = new ProductImage();

                    $product_image->isVariant = false;

                    $imageName = Str::slug($product->title . '-' . $i) . '.' . $request->file('images')[$i]->getClientOriginalExtension();
                    $path = public_path() . '/images/products/' . Str::slug($product->title) . '/';
                    $request->file('images')[$i]->move($path, $imageName);

                    $product_image->src = '/images/products/' . Str::slug($product->title) . '/' . $imageName;

                    $product_image->alt = $imageName;
                    $product_image->product_id = $product->id;

                    $product_image->save();

                    if ($i == 0) {
                        $product->image = $product_image->src;
                    }

                }
            }
        }

        $product->supplier_id = Auth::id();

        $product->save();

        //handle variants
        $quantities = $request->input('variant_quantity');
        $titles = $request->input('variant_title');
        $skus = $request->input('variant_sku');
        $individualOptions1 = $request->input('individualOptions1');
        $individualOptions2 = $request->input('individualOptions2');
        $individualOptions3 = $request->input('individualOptions3');
        $prices = $request->input('variant_price');
        $costs = $request->input('variant_cost');
        $barcodes = $request->input('variant_barcode');

        if($request->input('variant_title') != null){
            for ($i = 0; $i < count($request->input('variant_title')); $i++) {
                $variant = new ProductVariants();

                $variant->product_id = $product->id;
                $variant->grams = $request->input('grams');
                $variant->title = $titles[$i];
                $variant->sku = $skus[$i];
                $variant->option1 = $individualOptions1[$i];
                $variant->option2 = $individualOptions2[$i];
                $variant->option3 = $individualOptions3[$i];
                $variant->weight = '';
                $variant->weight_unit = '';
                $variant->price = $prices[$i];
                $variant->cost = $costs[$i];
                $variant->quantity = $quantities[$i];
                $variant->barcode = $barcodes[$i];

                $variant->save();

            }
        }


        $supplier = Auth::user();
        $user_product = new UserProduct();
        $user_product->product_id = $product->id;
        $user_product->user_id = $supplier->id;

        $user_product->save();

        return redirect()->route('products.edit',$product->id)->with('success', 'Product has been created successfully.');
    }

    public function show($id)
    {
        $product = Product::find($id);
        $product_images = ProductImage::where('product_id', $id)->first();
        $product_variants = ProductVariants::where('product_id', $id)->get();
        return view('products.product')->with([
            'product' => $product,
            'product_variants' => $product_variants,
            'product_images' => $product_images,
        ]);
    }

    public function edit(Product $product)
    {
        $variants = ProductVariants::where('product_id', $product->id)->get();
        $images = ProductImage::where('product_id', $product->id)->get();
        $categories = Category::all();

        return view('products.edit', compact('product', 'variants', 'images','categories'));
    }

    public function update(Request $request, Product $product)
    {
//        dd($request);
        request()->validate([
            'title' => 'required',
        ]);

        if($request->has('subcategory')){
            $product->sub_categories()->sync($request->input('subcategory'));
        }

        $product->title = $request->input('title');
        $product->body_html = $request->input('body_html');
        $product->cost = $request->input('cost');
        $product->price = $request->input('price');
        $product->sku = $request->input('sku');
        $product->vendor = $request->input('vendor');


        if ($request->has('images')) {

            if ($product->image != null || $product->image != '') {
                if (substr($product->image, 0, 7) == '/images/') {
                    unlink(public_path() . $product->image);
                }
            }
            //saving file
            $filesCount = 0;
            if ($request->has('images')) {
                $filesCount = count($request->file('images'));

            }


            if ($filesCount > 0) {
                for ($i = 0; $i < $filesCount; $i++) {
                    $product_image = new ProductImage();

                    $product_image->isVariant = false;

                    $imageName = Str::slug($product->title . '-' . $i) . '.' . $request->file('images')[$i]->getClientOriginalExtension();
                    $path = public_path() . '/images/products/' . Str::slug($product->title) . '/';
                    $request->file('images')[$i]->move($path, $imageName);

                    $product_image->src = '/images/products/' . Str::slug($product->title) . '/' . $imageName;

                    $product_image->alt = $imageName;
                    $product_image->product_id = $product->id;

                    $product_image->save();

                    if ($i == 0) {
                        $product->image = $product_image->src;
                    }

                }
            }
        }

        $product->option1 = $request->input('option1');
        $product->value1 = $request->input('value1');
        $product->option2 = $request->input('option2');
        $product->value2 = $request->input('value2');
        $product->option3 = $request->input('option3');
        $product->value3 = $request->input('value3');
        $product->type = $request->input('type');
        $product->tags = $request->input('tags');
        $product->status = $request->input('status');

        $product->save();

        $variants = $request->input('variant_id');
        $titles = $request->input('variant_title');
        $quantities = $request->input('variant_quantity');
        $skus = $request->input('variant_sku');
        $prices = $request->input('variant_price');
        $barcodes = $request->input('variant_barcode');


        if ($variants != null) {
            for ($i = 0; $i < count($variants); $i++) {

                $variant = ProductVariants::find($variants[$i]);

                $variant->grams = $request->input('grams');
                $variant->cost = $request->input('cost');

                $variant->title = $titles[$i];
                $variant->quantity = $quantities[$i];
                $variant->sku = $skus[$i];
                $variant->price = (int)$prices[$i];
                $variant->cost = $product->cost;
                $variant->barcode = $barcodes[$i];

                $variant->save();
            }
        }

//        return redirect()->route('products.index')
        return back()
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {

        $product_json = [
            'products' => Product::find($id),
            'options' => Option::where('product_id', $id)->get(),
            'product_images' => ProductImage::where('product_id', $id)->get(),
            'product_variants' => ProductVariants::where('product_id', $id)->get(),

        ];

        DB::table('user_products')->where('product_id', $id)->delete();
        DB::table('options')->where('product_id', $id)->delete();
        DB::table('product_variants')->where('product_id', $id)->delete();
        DB::table('product_images')->where('product_id', $id)->delete();

        $retailer_product = RetailerProduct::where('product_id', $id)->first();
        if ($retailer_product != null) {
//            $retailer_product->product_id = '';
//            $retailer_product->save();

            $product_delete_history = new ProductDeleteHistory();
            $product_delete_history->product_id = $id;
            $product_delete_history->product = json_encode($product_json);
            $product_delete_history->save();
        }

        Product::find($id)->delete();

        return back()
            ->with('success', 'Product deleted successfully');
    }

    public function destroyVariant($id)
    {
        DB::table('product_images')->where('variant_id', $id)->delete();
        DB::table('product_variants')->where('id', $id)->delete();

        return "deleted successfully";
    }

    public function product_add_variant_image(Request $request, $id)
    {
        $variant = ProductVariants::find($id);

        //check if any there's any picture which is already assigned to this variant

//        $checkVariantImage = ProductImage::fin

//        dd($variant);

        $image = new ProductImage();

        $image->isVariant = true;
        $image->product_id = $variant->product_id;
        $product = Product::where('id', $variant->product_id)->first();

        if ($request->has('variant_image')) {
            $imageFile = $request->file('variant_image');

            $imageName = substr(Str::slug($imageFile->getClientOriginalName()), 0, -3) . '.' . $imageFile->getClientOriginalExtension();
            $path = public_path() . '/images/products/' . Str::slug($product->title) . '/' . Str::slug($variant->title) . '/';
            $imageFile->move($path, $imageName);
            $image->src = '/images/products/' . Str::slug($product->title) . '/' . Str::slug($variant->title) . '/' . $imageName;
            $image->alt = $imageName;


            if ($image->save()) {
                $imageArray = [];
                if ($variant->shopify_variant_id != null) {
                    array_push($imageArray, (int)$variant->shopify_variant_id);
                    $image->variants_ids = json_encode($imageArray);
                    $image->variant_id = $variant->id;
                    $image->save();
                } else {
                    array_push($imageArray, $image->id);
                    $image->variants_ids = json_encode($imageArray);
                    $image->save();
                }

                $variant->image_id = $image->id;
                $variant->src = $image->src;
                $variant->save();
                return "saved";
            } else {
                return "error";
            }
        } else {
            return "no image";
        }
    }

    public function product_change_variant_image(Request $request){
        $product_image = ProductImage::find($request->image_id);
        $productVariant = ProductVariants::find($request->variant_id);
        if($product_image != null && $productVariant != null){

            $existing_image = ProductImage::find($productVariant->image_id);
            if($existing_image != null){
                $existing_image->variant_id = null;
                $existing_image->save();
            }

            $productVariant->image_id = $product_image->id;
            $productVariant->shopify_image_id = $product_image->shopify_image_id;
            $productVariant->src = $product_image->src;
            $productVariant->save();

            $variant_array  = json_decode($product_image->variants_ids);
            if(!in_array($productVariant->shopify_variant_id,$variant_array)){
                array_push($variant_array,$productVariant->shopify_variant_id);
                $product_image->variants_ids = json_encode($variant_array);
            }
            $product_image->variant_id = $productVariant->id;
            $product_image->save();

            return response()->json([
                'message' => "success"
            ]);
        }
        else{
            return response()->json([
                'message' => "Error"
            ]);
        }
    }

    public function destroyProductImage($id)
    {
        $product_image = ProductImage::find($id);

        $productVariants = ProductVariants::where('image_id', $product_image->id)->get();

        $image_array = [];

        if (count($productVariants) < 1) {
            $productVariants = ProductVariants::where('shopify_image_id', $product_image->shopify_image_id)->get();
        }

        $variant_ids = $product_image->variant_ids;
        foreach ($productVariants as $productVariant) {
            if ($variant_ids != null) {
                foreach (json_decode($product_image->variant_ids, true) as $image) {
                    if ($image == $productVariant->shopify_variant_id) {
                        continue;
                    } else {
                        array_push($image_array, (int)$image);
                    }
                }
            }

            $productVariant->image_id = null;
            $productVariant->shopify_image_id = null;
            $productVariant->src = null;
            $productVariant->save();
        }

        $product_image->variants_ids = json_encode($image_array);
        $product_image->save();

        if ($product_image->delete()) {
            return [
                'status' => 200,
                'message' => 'deleted'
            ];
        } else {
            return [
                'status' => 400,
                'message' => 'not deleted'
            ];
        }
    }

    //store products in bulk using shopify api to our database
    public function storeProductComingFromShopify($products, $id)
    {
        $shop = SupplierStores::find($id);
        $newProductsCount = 0;
        $markup_setting = Auth::user()->markup_setting;

        if ($markup_setting == null) {
            $markup_setting->user_id = Auth::id();
            $markup_setting->ask_every_time = true;
            $markup_setting->save();
        }

//        dd($markup_setting);

        foreach ($products as $product) {

            $checkIfAlreadyExist = Product::where('shopify_product_id', $product->id)->first();

            if ($checkIfAlreadyExist == null) {
                //its a new product fetch it
                $newProduct = new Product();

                $newProduct++;

                $newProduct->shopify_product_id = $product->id;
                $newProduct->title = $product->title;
                $newProduct->body_html = $product->body_html;
                $newProduct->vendor = $product->vendor;
                $newProduct->type = $product->product_type;
                $newProduct->status = true;
                $newProduct->handle = $product->handle;
                $newProduct->tags = $product->tags;
                $newProduct->supplier_id = Auth::id();
                $newProduct->save();

                $first = 0;
                foreach ($product->variants as $variant) {

                    //storing info at product level
                    if ($first == 0) {
                        $newProduct->cost = $variant->price;

                        if ($markup_setting != null && $markup_setting->ask_every_time == 0) {
                            if ($markup_setting->type == "percentage") {
                                $newProduct->price = $variant->price + ($variant->price * $markup_setting->value / 100);
                            } else if ($markup_setting->type == "fixed") {
                                $newProduct->price = $variant->price + $markup_setting->value;
                            } else if ($markup_setting->type == "multiplier") {
                                $newProduct->price = $variant->price * $markup_setting->value;
                            }
                        } else {
                            if ($shop->profit_margin_percentage != null && $shop->profit_margin_percentage != 0) {
                                $newProduct->price = $variant->price + ($variant->price * $shop->profit_margin_percentage / 100); // price to show retailer with percentage profit margin
                            } else {
                                $newProduct->price = $variant->price + $shop->profit_margin_fixed; // price to show retailer with fixed profit margin
                            }
                        }

                        $newProduct->grams = $variant->grams;
                        $newProduct->barcode = $variant->barcode;
                        $newProduct->sku = $variant->sku;
                        $first++;
                    }

                    //creating a local product variant
                    $newVariant = new ProductVariants();

                    $newVariant->product_id = $newProduct->id; //linked newly coming product from shopify with local
                    $newVariant->shopify_variant_id = $variant->id; //variant id from shopify
                    $newVariant->title = $variant->title;
                    $newVariant->cost = $variant->price; // price of supplier product is the cost for retailer
                    if ($markup_setting != null && $markup_setting->ask_every_time == 0) {
                        if ($markup_setting->type == "percentage") {
                            $newVariant->price = $variant->price + ($variant->price * $markup_setting->value / 100);
                        } else if ($markup_setting->type == "fixed") {
                            $newVariant->price = $variant->price + $markup_setting->value;
                        } else if ($markup_setting->type == "multiplier") {
                            $newVariant->price = $variant->price * $markup_setting->value;
                        }
                    } else {
                        if ($shop->profit_margin_percentage != null && $shop->profit_margin_percentage != 0) {
                            $newVariant->price = $variant->price + ($variant->price * $shop->profit_margin_percentage / 100); // price to show retailer with percentage profit margin
                        } else {
                            $newVariant->price = $variant->price + $shop->profit_margin_fixed; // price to show retailer with fixed profit margin
                            // dd($newVariant->price);
                        }
                    }
                    $newVariant->sku = $variant->sku;
                    $newVariant->option1 = $variant->option1;
                    $newVariant->option2 = $variant->option2;
                    $newVariant->option3 = $variant->option3;
                    $newVariant->weight = $variant->weight;
                    $newVariant->weight_unit = $variant->weight_unit;

                    if (isset($variant->inventory_quantity)) {
                        if ($variant->inventory_quantity > 0) {
                            $newVariant->quantity = $variant->inventory_quantity;
                        } else {
                            $newVariant->quantity = 0;
                        }

                    }
                    $newVariant->grams = $variant->grams;
                    $newVariant->shopify_image_id = $variant->image_id;


                    $newVariant->save();
                }

                //storing product level images
                $index = 0;
                foreach ($product->images as $image) {
                    //storing first image as product main image
                    if ($index == 0) {
                        $newProduct->image = $image->src;
                        $index++;
                    }

                    //creating local image object
                    $product_image = new ProductImage();

                    $product_image->shopify_image_id = $image->id; //coming from shopify
                    $product_image->product_id = $newProduct->id;
                    $product_image->alt = $image->alt;
                    $product_image->height = $image->height;
                    $product_image->width = $image->width;
                    $product_image->position = $image->position;
                    $product_image->src = $image->src;
                    $product_image->variants_ids = json_encode($image->variant_ids);
                    $product_image->isVariant = false;

                    $product_image->save();

                    //link image with variants
                    $checkHowManyVariantsAreLinkedWithImage = $image->variant_ids;
                    foreach ($checkHowManyVariantsAreLinkedWithImage as $shopify_variant_id) {
                        $localVariant = ProductVariants::where('shopify_variant_id', $shopify_variant_id)->first();

                        $localVariant->image_id = $product_image->id;
                        $localVariant->src = $product_image->src;
                        $localVariant->shopify_image_id = $product_image->shopify_image_id;

                        //yes this image is linked with variant
                        $product_image->isVariant = true;
                        $product_image->save();
                        $localVariant->save();
                    }
                }


                //storing variants options and values in PRODUCT table
                for ($i = 0; $i < count($product->options); $i++) {
                    if ($i == 0) {
                        $newProduct->option1 = $product->options[$i]->name;
                        $newProduct->value1 = json_encode($product->options[$i]->values);
                    } else if ($i == 1) {
                        $newProduct->option2 = $product->options[$i]->name;
                        $newProduct->value2 = json_encode($product->options[$i]->values);
                    } else if ($i == 2) {
                        $newProduct->option3 = $product->options[$i]->name;
                        $newProduct->value3 = json_encode($product->options[$i]->values);
                    }
                }

                foreach ($product->options as $product_option) {
                    $option = new Option();
                    $option->name = $product_option->name;
                    $option->product_id = $newProduct->id;
                    $option->position = $product_option->position;
                    $option->values = json_encode($product_option->values);
                    $option->save();
                }


                $newProduct->fromShopify = true; //is this product coming from shopify?
                $newProduct->shop_id = $id;
                $userProduct = UserProduct::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $newProduct->id,
                ]);
                $userProduct->save();

                if ($newProduct->save()) {
                    $newProductsCount++;
                }

            }
        }

        $shop->fetch_count = $shop->fetch_count + 1; //products from this shop has been fetched this many times
        $shop->save();

        if ($newProductsCount > 0) {
            if ($markup_setting->ask_every_time == 0) {
                return redirect()->route('supplier.stores')->with('success', 'Products from this shop are synced successfully.');
            } else {
                return [
                    'status' => 200,
                    'message' => "Products from this shop are synced successfully.",
                    'count' => $newProductsCount
                ];
            }

        } else {
            if ($markup_setting->ask_every_time == 0) {
                return redirect()->route('supplier.stores')->with('success', 'Products are synced already.');
            } else {
                return [
                    'status' => 200,
                    'message' => "Products are synced already."
                ];
            }

        }
    }

    public function mange_products()
    {
        $productsCount = Product::all()->count();

        $products = '';

        if ($productsCount > 28) {
            $products = Product::take(28)->get();
        } else {
            $products = Product::all();
        }

        $categories = Category::take(12)->get();
        $all_categories = Category::take(30)->get();
        return view('products.manage_products', compact('products', 'categories', 'all_categories'));
    }

    public function search_products(Product $product, Request $request)
    {
        $user = Auth::user();
//        $products = Product::paginate(30);

        $markup_settings = MarkupSetting::where('user_id', $user->id)->first();
        $retailer_products = RetailerProduct::where('retailer_id', $user->id)->pluck('product_id')->toArray();

        $vendors_array = Product::where('vendor', '!=', '')->distinct()->pluck('vendor')->toArray();
        $vendors = [];
        foreach ($vendors_array as $vendor) {
            array_push($vendors, [
                'vendor' => $vendor,
                'product_count' => Product::where('vendor', $vendor)->count()
            ]);
        }

        $products = $product->newQuery();
        $search = $request->input('search');
        $selected_category = '';
        $sub_categories = '';
        $selected_sub_category = '';
        $selected_price_filter = '';
        $selected_vendor_filter = '';
        $selected_filter_type = '';
        $vendors = [];

        $shop = \OhMyBrew\ShopifyApp\Facades\ShopifyApp::shop();
        $supplierQuery = User::role('supplier')->get();
        $supplier_ids = [];
        foreach ($supplierQuery as $s){
            if(count($s->restricted_stores) > 0){
                if(in_array($shop->id,$s->restricted_stores->pluck('id')->toArray())){
                    array_push($supplier_ids,$s->id);
                }
            }
        }
        $products->whereHas('linked_supplier', function ($q) use ( $supplier_ids) {
            $q->whereIN('id', $supplier_ids);
            $q->where('status',1);
            return $q;
        });

        if (request('filter_by')) {
            $products->when(request('filter_by') == 'price', function ($q) {
                if (request('type')) {
                    if (request('type') == 'lowest') {
                        return $q->orderBy(request('filter_by'), 'asc');
                    } else if (request('type') == 'highest') {
                        return $q->orderBy(request('filter_by'), 'desc');
                    }
                }
                return;
            });
        }
        if (request('price-filter')) {
            $products->when(request('price-filter') == '0', function ($q) use ($selected_price_filter) {
                $selected_price_filter = 0;
                return;
            });

            $products->when(request('price-filter') == '1', function ($q) {
                return $q->whereBetween('price', [0, 10]);
            });

            $products->when(request('price-filter') == '2', function ($q) {
                return $q->whereBetween('price', [11, 100]);
            });

            $products->when(request('price-filter') == '3', function ($q) {
                return $q->whereBetween('price', [101, 500]);
            });

            $products->when(request('price-filter') == '4', function ($q) {
                return $q->where('price', '>=', 500);
            });
        }
        if (request('category-filter')) {
            $category = urldecode(request('category-filter'));
            $selected_category = Category::whereName($category)->first();

            if ($selected_category != null) {
                $sub_categories = $selected_category->sub_categories;

                $products->whereHas('sub_categories', function ($q) use ($selected_category, $request) {
                    return $q->where('category_id', $selected_category->id);
                });
            }

        }
        if (request('vendor-filter')) {
            $vendors_filter = request('vendor-filter');
            foreach ($vendors_filter as $vendor) {
                $products->orWhere('vendor', $vendor);
            }
        }
        if ($search) {
            $products->when($search != null, function ($q) {
                return $q->where('title', 'like', '%' . request('search') . '%');
            });
        }

        $categories = Category::all();
        $vendors_array = Product::where('vendor', '!=', '')->distinct()->pluck('vendor')->toArray();

        foreach ($vendors_array as $vendor) {
            array_push($vendors, [
                'vendor' => $vendor,
                'product_count' => Product::where('vendor', $vendor)
                    ->where('supplier_id', '!=', null)
                    ->count()
            ]);
        }

        if (request('selected_category')) {
            $selected_category = Category::find(request('selected_category'));
        }
        if (request('selected_sub_category')) {
            $selected_category = SubCategory::find(request('selected_sub_category'));
        }
        if (request('price-filter')) {
            $selected_price_filter = request('price-filter');
        }
        if (request('vendor-filter')) {
            $selected_vendor_filter = request('vendor-filter');
        }
        if (request('type')) {
            $selected_filter_type = request('type');
        }




        \Debugbar::info('product count: ' . $products->count());

        return view('products.search_products')->with([
            'products' => $products->orderBy('created_at', 'desc')
                ->where('supplier_id', '!=', null)
                ->where('status', true)
                ->paginate(30)
                ->appends(Input::except('page')),
            'vendors' => $vendors,
            'retailer_products' => $retailer_products,
            'markup_settings' => $markup_settings,
            'selected_category' => $selected_category,
            'selected_sub_category' => $selected_sub_category,
            'selected_price_filter' => $selected_price_filter,
            'selected_vendor_filter' => $selected_vendor_filter,
            'selected_filter_type' => $selected_filter_type,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'request' => $request,
            'search_term' => $search,
            'productsCount' => $products->count(),
            'paginate' => true,
            'shop' => $shop
        ]);

    }

    public function show_by_subcategory($id)
    {
        $categories = Category::all();
        $sub_category = SubCategory::find($id);
        $selected_category = $sub_category->category;
        $sub_categories = $selected_category->sub_categories;
        $selected_sub_category = $id;
        $products = $sub_category->products;
        $paginate = false;

        if (Auth::user()->hasRole('retailer')) {
            $retailer_products = RetailerProduct::where('retailer_id', Auth::id())->pluck('product_id')->toArray();

            $vendors_array = Product::where('vendor', '!=', '')->distinct()->pluck('vendor')->toArray();
            $vendors = [];
            foreach ($vendors_array as $vendor) {
                array_push($vendors, [
                    'vendor' => $vendor,
                    'product_count' => Product::where('vendor', $vendor)->count()
                ]);
            }

            return view('products.search_products', compact('retailer_products', 'selected_category',
                'selected_sub_category', 'products', 'sub_categories', 'paginate', 'categories', 'vendors'
            ));
        }


        return view('products.search_products', compact('selected_category',
            'selected_sub_category', 'products', 'sub_categories', 'paginate', 'categories'
        ));
    }

    public function show_products_by_filter($filter)
    {
        $products = [];
        if ($filter == 1) {
            $products = Product::orderBy('price', 'asc')->paginate(30);
        } else if ($filter == 2) {
            $products = Product::orderBy('price', 'desc')->paginate(30);
        }


        $categories = Category::all();
        $vendors_array = Product::where('vendor', '!=', '')->distinct()->pluck('vendor')->toArray();
        $vendors = [];
        foreach ($vendors_array as $vendor) {
            array_push($vendors, [
                'vendor' => $vendor,
                'product_count' => Product::where('vendor', $vendor)->count()
            ]);
        }
        $paginate = true;


        if (Auth::user()->hasRole('retailer')) {
            $retailer_products = RetailerProduct::where('retailer_id', Auth::id())->pluck('product_id')->toArray();


            return view('products.search_products', compact('retailer_products', 'products', 'categories', 'paginate', 'vendors'));
        }

        return view('products.search_products', compact('vendors', 'categories', 'products', 'paginate', 'categories'));
    }

    public function show_products_by_filter_and_category($category_id, $filter)
    {

        $selected_category = Category::find($category_id);
        $categories = Category::all();
        //retailer and admin can see all products of all categories
        $sub_categories = SubCategory::where('category_id', $selected_category->id)->get();
        $products = [];
        foreach ($sub_categories as $sub_category) {
            $products_count = count($products);

            if (count($sub_category->products) > 0 && $products_count < 31) {
                if ($filter == 1) {
                    array_push($products, $sub_category->products()->orderBy('price', 'asc')->paginate(30));
                } else {
                    array_push($products, $sub_category->products()->orderBy('price', 'desc')->paginate(30));
                }
            }

            \Debugbar::error($products_count);
        }


        if ($products != null) {
            $products = $products[0];
            $paginate = true;

        } else {
            $paginate = false;
        }


        if (Auth::user()->hasRole('retailer')) {
            $retailer_products = RetailerProduct::where('retailer_id', Auth::id())->pluck('product_id')->toArray();
            $vendors_array = Product::where('vendor', '!=', '')->distinct()->pluck('vendor')->toArray();
            $vendors = [];
            foreach ($vendors_array as $vendor) {
                array_push($vendors, [
                    'vendor' => $vendor,
                    'product_count' => Product::where('vendor', $vendor)->count()
                ]);
            }
            return view('products.search_products', compact('retailer_products', 'selected_category', 'products', 'sub_categories', 'paginate', 'categories', 'vendors'
            ));
        }
        return view('products.search_products', compact('selected_category', 'products', 'sub_categories',
            'paginate', 'categories'));

    }

    public function test_product_filter(Product $product, Request $request)
    {
        $products = $product->newQuery();
        $selected_category = '';
        $sub_categories = '';
        $selected_sub_category = '';
        $selected_price_filter = '';
        $selected_vendor_filter = '';
        $selected_filter_type = '';
        $vendors = [];
        $productsCount = Product::all()->count();

//        dd($request);


        if (request('filter_by')) {
            $products->when(request('filter_by') == 'price', function ($q) {
                if (request('type')) {
                    if (request('type') == 'lowest') {
                        return $q->orderBy(request('filter_by'), 'asc');
                    } else if (request('type') == 'highest') {
                        return $q->orderBy(request('filter_by'), 'desc');
                    }
                }

                return;
            });
        }
        if (request('price-filter')) {
            $products->when(request('price-filter') == '0', function ($q) use ($selected_price_filter) {
                $selected_price_filter = 0;
                return;
            });

            $products->when(request('price-filter') == '1', function ($q) {
                return $q->whereBetween('price', [0, 10]);
            });

            $products->when(request('price-filter') == '2', function ($q) {
                return $q->whereBetween('price', [11, 100]);
            });

            $products->when(request('price-filter') == '3', function ($q) {
                return $q->whereBetween('price', [101, 500]);
            });

            $products->when(request('price-filter') == '4', function ($q) {
                return $q->where('price', '>=', 500);
            });
        }
        if (request('category-filter')) {
            $category = urldecode(request('category-filter'));
            $selected_category = Category::whereName($category)->first();

            if ($selected_category != null) {
                $sub_categories = $selected_category->sub_categories;

                $products->whereHas('sub_categories', function ($q) use ($selected_category, $request) {
                    return $q->where('category_id', $selected_category->id);
                });
            }

        }
        if (request('vendor-filter')) {
            $vendors_filter = request('vendor-filter');
            foreach ($vendors_filter as $vendor) {
                $products->orWhere('vendor', $vendor);
            }


        }

        $categories = Category::all();
        $vendors_array = Product::where('vendor', '!=', '')->distinct()->pluck('vendor')->toArray();

        foreach ($vendors_array as $vendor) {
            array_push($vendors, [
                'vendor' => $vendor,
                'product_count' => Product::where('vendor', $vendor)->count()
            ]);
        }

        if (request('selected_category')) {
            $selected_category = Category::find(request('selected_category'));
        }
        if (request('selected_sub_category')) {
            $selected_category = SubCategory::find(request('selected_sub_category'));
        }
        if (request('price-filter')) {
            $selected_price_filter = request('price-filter');
        }
        if (request('vendor-filter')) {
            $selected_vendor_filter = request('vendor-filter');
        }
        if (request('type')) {
            $selected_filter_type = request('type');
        }

//        dd($products->paginate(30));

//        dd($selected_vendor_filter);


        return view('products.search_products')->with([
            'products' => $products->paginate(30)->appends(Input::except('page')),
            'vendors' => $vendors,
            'selected_category' => $selected_category,
            'selected_sub_category' => $selected_sub_category,
            'selected_price_filter' => $selected_price_filter,
            'selected_vendor_filter' => $selected_vendor_filter,
            'selected_filter_type' => $selected_filter_type,
            'categories' => $categories,
            'sub_categories' => $sub_categories,
            'request' => $request,
            'productsCount' => $products->count(),
            'paginate' => true,
        ]);

    }
}
