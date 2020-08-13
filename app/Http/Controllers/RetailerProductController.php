<?php

namespace App\Http\Controllers;

use App\Category;
use App\MarkupSetting;
use App\Option;
use App\Product;
use App\ProductImage;
use App\ProductVariants;
use App\RetailerProduct;
use App\RetailerProductImage;
use App\RetailerProductOption;
use App\RetailerProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use OhMyBrew\ShopifyApp\Facades\ShopifyApp;


class RetailerProductController extends Controller
{
    public function index(Request $request)
    {

        $retailer_drafts = RetailerProduct::where('retailer_id', Auth::user()->id)
            ->where('toShopify', '=', true)
            ->orderBy('created_at', 'desc')
        ->newQuery();
        if($request->has('filter-by-name')){
            $retailer_drafts->where('title','LIKE','%'.$request->input('filter-by-name').'%');
        }
        $retailer_drafts =$retailer_drafts->paginate(30);
        $pageType = 'my products';
        $queryName = $request->input('filter-by-name');

        return view('retailer.imported_products.index',
            compact('retailer_drafts', 'pageType','queryName'));
    }

    //adding multiple supplier products to import list
    public function store(Request $request)
    {
        $user = Auth::user();
        $products = $request->input('products');
        $percentage = $request->input('percentage');
        $fixed = $request->input('fixed');

        $markup_settings = MarkupSetting::where('user_id', $user->id)
            ->first();

        if ($markup_settings == null) {
            $markup_settings = new MarkupSetting();
            $markup_settings->ask_every_time = 1;
            $markup_settings->user_id = $user->id;
            $markup_settings->save();
        }

        for ($i = 0; $i < count($products); $i++) {

            $checkIfRetailerHasAlreadyAddedProduct = RetailerProduct::where('product_id', $products[$i])
                ->where('retailer_id', $user->id)
                ->first();
            if ($checkIfRetailerHasAlreadyAddedProduct == null) {
                //create a retailer's copy of product

                $product = Product::find($products[$i]);//find actual product
                Product::whereId($products[$i])
                    ->update(["sold_count" => intval($product->sold_count) + 1]);

                $retailer_product = new RetailerProduct(); //create new retailer product
                $retailer_product->product_id = $product->id;
                $retailer_product->retailer_id = Auth::id();
                $retailer_product->title = $product->title;
                $retailer_product->body_html = $product->body_html;
                $retailer_product->toShopify = false;
                $retailer_product->cost = $product->price; //price of supplier product is the cost for retailer

               //add profit margin set by retailer to its product price
                if ($markup_settings->ask_every_time == 0) {
                    if ($markup_settings->type == 'percentage') {
                        $retailer_product->price = $product->price + (($product->price / 100) * $markup_settings->value);
                    } else if ($markup_settings->type == 'fixed') {
                        $retailer_product->price = $product->price + $markup_settings->value;
                    } else if ($markup_settings->type == 'multiplier') {
                        $retailer_product->price = $product->price * $markup_settings->value;
                    }
                }
                else if ($markup_settings->ask_every_time == 1) {
                    //when user has set to ask for price each time
                    if ($percentage != null) {
                        $price = floatval($product->price + (($product->price / 100) * $percentage));
                    } else {
                        $price = $product->price + $fixed;
                    }
                    $retailer_product->price = $price; //price includes the profit margin set by retailer
                }

                $retailer_product->sku = $product->sku;
                $retailer_product->barcode = $product->barcode;
                $retailer_product->vendor = $product->vendor;
                $retailer_product->grams = $product->grams;
                $retailer_product->option1 = $product->option1;
                $retailer_product->value1 = $product->value1;
                $retailer_product->option2 = $product->option2;
                $retailer_product->value2 = $product->value2;
                $retailer_product->option3 = $product->option3;
                $retailer_product->value3 = $product->value3;
                $retailer_product->type = $product->type;
                $retailer_product->handle = $product->handle;
                $retailer_product->image = $product->image;
                $retailer_product->tags = $product->tags;
                $retailer_product->status = 0;

                $retailer_product->save();

                $productOptions = Option::where('product_id', $products[$i])
                    ->get();

                foreach ($productOptions as $productOption) {
                    $option = new RetailerProductOption();
                    $option->retailer_product_id = $retailer_product->id;
                    $option->name = $productOption->name;
                    $option->position = $productOption->position;
                    $option->values = $productOption->values;
                    $option->save();
                }

                $product_variants = ProductVariants::where('product_id', $products[$i])->get();
                foreach ($product_variants as $product_variant) {
                    $retailer_product_variant = new RetailerProductVariant();
                    $retailer_product_variant->retailer_product_id = $retailer_product->id;
                    $retailer_product_variant->grams = $product_variant->grams;
                    $retailer_product_variant->title = $product_variant->title;
                    $retailer_product_variant->sku = $product_variant->sku;
                    $retailer_product_variant->option1 = $product_variant->option1;
                    $retailer_product_variant->option2 = $product_variant->option2;
                    $retailer_product_variant->option3 = $product_variant->option3;
                    $retailer_product_variant->weight = $product_variant->weight;
                    $retailer_product_variant->weight_unit = $product_variant->weight_unit;
                    $retailer_product_variant->quantity = $product_variant->quantity;
                    $retailer_product_variant->barcode = $product_variant->barcode;
                    $retailer_product_variant->src = $product_variant->src;
                    $retailer_product_variant->shopify_image_id = $product_variant->shopify_image_id;
                    $retailer_product_variant->local_shopify_variant_id = $product_variant->shopify_variant_id;
                    $retailer_product_variant->cost = $product_variant->price;

                    //price includes the profit margin set by retailer
                    if ($markup_settings->ask_every_time == 0) {
                        //if markup price has been set already
                        if ($markup_settings->type == 'percentage') {
                            $retailer_product_variant->price = $product->price + (($product->price / 100) * $markup_settings->value);
                        } else if ($markup_settings->type == 'fixed') {
                            $retailer_product_variant->price = $product->price + $markup_settings->value;
                        } else if ($markup_settings->type == 'multiplier') {
                            $retailer_product_variant->price = $product->price * $markup_settings->value;
                        }
                    }
                    else if ($markup_settings->ask_every_time == 1) {
                        //when user has set to ask for price each time
                        if ($percentage != null) {
                            $price = floatval($product->price + (($product->price / 100) * $percentage));
                        } else {
                            $price = $product->price + $fixed;
                        }
                        $retailer_product_variant->price = $price; //price includes the profit margin set by retailer
                    }
                    $retailer_product_variant->save();
                }

                $productImages = ProductImage::where('product_id', $products[$i])->get();
                foreach ($productImages as $productImage) {
                    $retailer_product_image = new RetailerProductImage();
                    $retailer_product_image->retailer_product_id = $retailer_product->id;
                    $retailer_product_image->retailer_product_variant_id = $retailer_product_variant->id;
                    $retailer_product_image->shopify_image_id = $productImage->shopify_image_id;
                    $retailer_product_image->isVariant = $productImage->isVariant;
                    $retailer_product_image->alt = $productImage->alt;
                    $retailer_product_image->position = $productImage->position;
                    $retailer_product_image->height = $productImage->height;
                    $retailer_product_image->width = $productImage->width;
                    $retailer_product_image->src = $productImage->src;
                    $retailer_product_image->variant_ids = $productImage->variants_ids;
                    $retailer_product_image->save();
                }
                $retailer_product->save();
            }
        }

        return [
            'status' => 200,
            'message' => 'Your selected products have been added to import list successfully'
        ];
    }

    public function show($id)
    {
        $retailerProduct = RetailerProduct::find($id);
        $retailer_product_images = RetailerProductImage::where('retailer_product_id', $retailerProduct->id)->first();


        return view('retailer.imported_products.show', compact('retailerProduct', 'retailer_product_images'));
    }

    public function edit($id)
    {
        $product = RetailerProduct::find($id);
        $variants = RetailerProductVariant::where('retailer_product_id', $product->id)->get();
        $images = RetailerProductImage::where('retailer_product_id', $product->id)->get();


        return view('retailer.imported_products.edit', compact('product', 'variants', 'images'));
    }

    public function update(Request $request, $id)
    {

        request()->validate([
            'title' => 'required',
        ]);

        $product = RetailerProduct::find($id);

        $product->title = $request->input('title');
        $product->body_html = $request->input('body_html');
        $product->cost = $request->input('cost');
        $product->price = RetailerProductVariant::where('retailer_product_id', $id)->first()->price;
        $product->sku = $request->input('sku');
        $product->vendor = $request->input('vendor');


        $product->type = $request->input('type');
        $product->tags = $request->input('tags');
        $product->status = 1;

        $product->save();

        $variants = $request->input('variant_id');
        $prices = $request->input('variant_price');
        $quantity = $request->input('variant_quantity');
        $barcodes = $request->input('variant_barcode');

        for ($i = 0; $i < count($variants); $i++) {

            $variant = RetailerProductVariant::find($variants[$i]);
            $variant->grams = $request->input('grams');
            $variant->cost = $request->input('cost');
            $variant->price = $prices[$i];
            $variant->quantity = $quantity[$i];
            $variant->save();
        }
        return back()
            ->with('success', 'Product updated successfully');
    }

    public function bulk_destroy(Request $request){
        foreach ($request->input('products') as $id){
            $product = RetailerProduct::find($id);
            DB::table('retailer_product_options')->where('retailer_product_id', $product->id)->delete();
            DB::table('retailer_product_variants')->where('retailer_product_id', $product->id)->delete();
            DB::table('retailer_product_images')->where('retailer_product_id', $product->id)->delete();
            $product->delete();
        }

        return [
            'status' => 200,
            'message' => 'deleted',
        ];

    }

    public function destroy($id)
    {
        $product = RetailerProduct::find($id);
        $response = '';
        if ($product->toShopify) {
            $shop = ShopifyApp::shop();
            $response = $shop->api()->rest('DELETE', '/admin/api/2020-01/products/' . $product->shopify_product_id . '.json');

        }
        DB::table('retailer_product_options')->where('retailer_product_id', $product->id)->delete();
        DB::table('retailer_product_variants')->where('retailer_product_id', $product->id)->delete();
        DB::table('retailer_product_images')->where('retailer_product_id', $product->id)->delete();
        $product->delete();

//        dd($response);

        return back()
            ->with('success', 'Product has been removed successfully');
    }


    public function destroyVariant($id)
    {

        DB::table('retailer_product_images')->where('retailer_product_variant_id', $id)->delete();
        DB::table('retailer_product_variants')->where('id', $id)->delete();

        return "deleted successfully";
    }

    public function product_add_variant_image(Request $request, $id)
    {

        $variant = RetailerProductVariant::find($id);

        $image = new RetailerProductImage();

        $image->isVariant = true;
        $image->retailer_product_id = $variant->retailer_product_id;
        $image->variant_ids = json_encode([$variant->shopify_variant_id]);
        $product = RetailerProduct::where('id', $variant->retailer_product_id)->first();

        if ($request->has('image')) {
            $imageFile = $request->file('image');

            $imageName = substr(Str::slug($imageFile->getClientOriginalName()), 0, -3) . '.' . $imageFile->getClientOriginalExtension();
            $path = public_path() . '/images/products/retailer/' . Str::slug($product->title) . '/' . Str::slug($variant->title) . '/';
            $imageFile->move($path, $imageName);
            $image->src = '/images/products/retailer/' . Str::slug($product->title) . '/' . Str::slug($variant->title) . '/' . $imageName;
            $image->alt = $imageName;

            if ($image->save()) {
                $variant->retailer_product_image_id = $image->id;
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

    public function destroyProductImage($id)
    {
        $product_image = RetailerProductImage::find($id);
        $retailerProductVariants = RetailerProductVariant::where('retailer_product_image_id', $product_image->id)->get();
        $image_array = [];
        if (count($retailerProductVariants) < 1) {
            $retailerProductVariants = RetailerProductVariant::where('shopify_image_id', $product_image->shopify_image_id)->get();
        }
        $variant_ids = $product_image->variant_ids;
        foreach ($retailerProductVariants as $retailerProductVariant) {

            if ($variant_ids != null) {
                foreach (json_decode($product_image->variant_ids, true) as $image) {
                    if ($image == $retailerProductVariant->local_shopify_variant_id) {
                        continue;
                    } else {
                        array_push($image_array, (int)$image);
                    }
                }
            }

            $retailerProductVariant->retailer_product_image_id = null;
            $retailerProductVariant->src = null;
            $retailerProductVariant->save();
        }


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

    //push single product to SHOPIFY using api
    public function push_to_shopify(Request $request, $retailerProductId)
    {
        $retailerProduct = RetailerProduct::find($retailerProductId);
        $retailerProductImages = RetailerProductImage::where('retailer_product_id', $retailerProductId)->get();
        $retailerProductOptions = $retailerProduct->options;
        $retailerProductVariants = $retailerProduct->variants;

        $variants_array = [];
        $options_array = [];
        $images_array = [];


        //converting variants into shopify api format
        foreach ($retailerProductVariants as $retailerProductVariant) {
            array_push($variants_array, [
                'title' => $retailerProductVariant->title,
                'image_id' => $retailerProductVariant->image_id,
                'sku' => $retailerProductVariant->sku,
                'option1' => $retailerProductVariant->option1,
                'option2' => $retailerProductVariant->option2,
                'option3' => $retailerProductVariant->option3,
//                'inventory_quantity' => $retailerProductVariant->quantity,
//                'inventory_management' => 'shopify',
                'grams' => $retailerProductVariant->grams,
                'weight' => $retailerProductVariant->weight,
                'weight_unit' => $retailerProductVariant->weight_unit,
                'barcode' => $retailerProductVariant->barcode,
                'price' => $retailerProductVariant->price,
                'cost' => $retailerProductVariant->cost,
            ]);
        }

        //converting options into shopify api format
        foreach ($retailerProductOptions as $retailerProductOption) {

            array_push($options_array, [
                'name' => $retailerProductOption->name,
                'position' => $retailerProductOption->position,
                'values' => $retailerProductOption->values,
            ]);
        }

        //converting images into shopify api format
        foreach ($retailerProductImages as $retailerProductImage) {
            $image_src = '';

            if (substr($retailerProductImage->src, 0, 8) == '/images/') {
                $image_src = env('APP_URL') . $retailerProductImage->src;
            } else {
                $image_src = $retailerProductImage->src;
            }

            array_push($images_array, [
                'alt' => $retailerProductImage->alt,
                'position' => $retailerProductImage->position,
                'height' => $retailerProductImage->height,
                'width' => $retailerProductImage->width,
                'src' => $image_src,
            ]);
        }

        $shop = ShopifyApp::shop();

        $product = [
            "product" => [
                "title" => $retailerProduct->title,
                "body_html" => $retailerProduct->body_html,
                "vendor" => $retailerProduct->vendor,
                "handle" => $retailerProduct->handle,
                "tags" => $retailerProduct->tags.','.$retailerProduct->linked_supplier_product->linked_supplier->name,
                "product_type" => $retailerProduct->type,
                "variants" => $variants_array,
                "options" => $options_array,
                "images" => $images_array,
            ]
        ];

        // TODO: 'control the flow where product have images which are not already uploaded to shopify'

        $response = $shop->api()->rest('POST', '/admin/api/2019-10/products.json', $product);

        $retailerProduct->toShopify = 1;
        $retailerProduct->shopify_product_id = $response->body->product->id;
        $price = $retailerProduct->price;
//        $retailerProduct->price = $response->body->product->variants[0]->price;
        $retailerProduct->status = 1;
        $retailerProduct->save();


        $shopifyImages = $response->body->product->images;

        $shopifyVariants = $response->body->product->variants;
        if(count($retailerProductVariants) == 0){
            $variant_id = $shopifyVariants[0]->id;
            $i = [
                'variant' => [
                    'price' =>$price
                ]
            ];
            $shop->api()->rest('PUT', '/admin/api/2019-10/variants/' . $variant_id .'.json', $i);
        }

        foreach ($retailerProductVariants as $index => $variant) {
            $variant->price = $shopifyVariants[$index]->price;
            $variant->shopify_variant_id = $shopifyVariants[$index]->id;
            $variant->save();
        }

        //store images id coming back from shopify
        foreach ($retailerProductImages as $index => $image) {

            if ($shopifyImages != null) {
                $image->shopify_image_id = $shopifyImages[$index]->id;

            }

            if ($image->variant_ids != null) {
                foreach (json_decode($image->variant_ids, true) as $variant) {
                    $localVariant = RetailerProductVariant::where('local_shopify_variant_id', '=', $variant)->first();
                    if ($image->shopify_image_id != null) {
                        $localVariant->shopify_image_id = $image->shopify_image_id;
                        $localVariant->save();
                    }
                }
            }


            $image->save();
        }

        //assign variant images
        foreach ($retailerProductImages as $image) {
            $variantsShopifyImageIds = DB::table('retailer_product_variants')
                ->where('retailer_product_id', $retailerProductId)
                ->where('shopify_image_id', $image->shopify_image_id)
                ->get();

            $variant_ids = [];

            foreach ($variantsShopifyImageIds as $variantsShopifyImageId) {
                array_push($variant_ids, $variantsShopifyImageId->shopify_variant_id);
            }

            $i = [
                'image' => [
                    'id' => $image->shopify_image_id,
                    'variant_ids' => $variant_ids
                ]
            ];

            $imagesResponse = $shop->api()->rest('PUT', '/admin/api/2019-10/products/' . $retailerProduct->shopify_product_id . '/images/' . $image->shopify_image_id . '.json', $i);
            Log::critical("imagesResponse: " . json_encode($imagesResponse));
        }

        if ($response->errors) {
            return [
                'status' => 400,
                'message' => 'Product does not pushed to shopify'
            ];
        } else {
            return [
                'status' => 200,
                'message' => 'saved',
                'response' => json_encode($response)
            ];
        }
    }

    //push multiple products to SHOPIFY using api
    public function push_products_to_shopify(Request $request)
    {
        $getProducts = $request->input('products');
        $response = '';

        foreach ($getProducts as $product) {
            $retailerProduct = RetailerProduct::find($product);
            $retailerProductOptions = RetailerProductOption::where('retailer_product_id', $product)
                ->get();
            $retailerProductVariants = RetailerProductVariant::where('retailer_product_id', $product)
                ->get();
            $retailerProductImages = RetailerProductImage::where('retailer_product_id', $product)
                ->get();

            $variants_array = [];
            $options_array = [];
            $images_array = [];

            //converting variants into shopify api format
            foreach ($retailerProductVariants as $retailerProductVariant) {

                array_push($variants_array, [
                    'title' => $retailerProductVariant->title,
                    'image_id' => $retailerProductVariant->image_id,
                    'sku' => $retailerProductVariant->sku,
                    'option1' => $retailerProductVariant->option1,
                    'option2' => $retailerProductVariant->option2,
                    'option3' => $retailerProductVariant->option3,
//                    'inventory_quantity' => $retailerProductVariant->quantity,
//                    'inventory_management' => 'shopify',
                    'grams' => $retailerProductVariant->grams,
                    'weight' => $retailerProductVariant->weight,
                    'weight_unit' => $retailerProductVariant->weight_unit,
                    'barcode' => $retailerProductVariant->barcode,
                    'cost' => $retailerProductVariant->cost,
                    'price' => $retailerProductVariant->price,
                ]);
            }

            //converting options into shopify api format
            foreach ($retailerProductOptions as $retailerProductOption) {

                array_push($options_array, [
                    'name' => $retailerProductOption->name,
                    'position' => $retailerProductOption->position,
                    'values' => $retailerProductOption->values,
                ]);
            }

            //converting images into shopify api format
            foreach ($retailerProductImages as $retailerProductImage) {
                $image_src = '';
                Log::critical('retailerProductImage:  ' . $retailerProductImage);

                if (substr($retailerProductImage->src, 0, 8) != '/images/') {
                    $image_src = $retailerProductImage->src;
                } else {
                    $image_src = env('APP_URL') . $retailerProductImage->src;
                }
                array_push($images_array, [
                    'title' => $retailerProductImage->title,
                    'alt' => $retailerProductImage->alt,
                    'position' => $retailerProductImage->position,
                    'height' => $retailerProductImage->height,
                    'width' => $retailerProductImage->width,
                    'src' => $image_src,
                ]);
            }

            $shop = ShopifyApp::shop();

            $product = [
                "product" => [
                    "title" => $retailerProduct->title,
                    "body_html" => $retailerProduct->body_html,
                    "vendor" => $retailerProduct->vendor,
                    "handle" => $retailerProduct->handle,
                    "tags" => $retailerProduct->tags.','.$retailerProduct->linked_supplier_product->linked_supplier->name,
                    "product_type" => $retailerProduct->type,
                    "variants" => $variants_array,
                    "options" => $options_array,
                    "images" => $images_array,
                ]
            ];

            $response = $shop->api()->rest('POST', '/admin/api/2019-10/products.json', $product);


            if ($response->errors) {
                return [
                    'status' => 400,
                    'message' => 'Product does not pushed to shopify',
                    'response' => $response
                ];
            }

            $retailerProduct->toShopify = 1;
            $retailerProduct->shopify_product_id = $response->body->product->id;
            $price = $retailerProduct->price;
//            $retailerProduct->price = $response->body->product->variants[0]->price;
            $retailerProduct->status = 1;
            $retailerProduct->save();

            $shopifyImages = $response->body->product->images;
            $shopifyVariants = $response->body->product->variants;

            if(count($retailerProductVariants) == 0){
                $variant_id = $shopifyVariants[0]->id;
                $i = [
                    'variant' => [
                        'price' =>$price
                    ]
                ];
                $shop->api()->rest('PUT', '/admin/api/2019-10/variants/' . $variant_id .'.json', $i);
            }
            foreach ($retailerProductVariants as $index => $variant) {
                Log::info('Shopify variant id after creating new product on user store');
                Log::info($shopifyVariants[$index]->id);
                $variant->price = $shopifyVariants[$index]->price;
                $variant->shopify_variant_id = $shopifyVariants[$index]->id;
                $variant->save();
            }

            //store images id coming back from shopify
            foreach ($retailerProductImages as $index => $image) {
                $image->shopify_image_id = $shopifyImages[$index]->id;

                foreach (json_decode($image->variant_ids, true) as $variant) {
                    $localVariant = RetailerProductVariant::where('local_shopify_variant_id', '=', $variant)->first();
                    $localVariant->shopify_image_id = $image->shopify_image_id;
                    $localVariant->save();
                }

                $image->save();
            }

            //assign variant images
            foreach ($retailerProductImages as $image) {
                $variantsShopifyImageIds = DB::table('retailer_product_variants')
                    ->where('retailer_product_id', $retailerProduct->id)
                    ->where('shopify_image_id', $image->shopify_image_id)
                    ->get();

                $variant_ids = [];

                foreach ($variantsShopifyImageIds as $variantsShopifyImageId) {
                    array_push($variant_ids, $variantsShopifyImageId->shopify_variant_id);
                }

                $i = [
                    'image' => [
                        'id' => $image->shopify_image_id,
                        'variant_ids' => $variant_ids
                    ]
                ];

                $imagesResponse = $shop->api()->rest('PUT', '/admin/api/2019-10/products/' . $retailerProduct->shopify_product_id . '/images/' . $image->shopify_image_id . '.json', $i);
                Log::critical("imagesResponse: " . json_encode($imagesResponse));
            }
        }

        if ($response->errors) {
            return [
                'status' => 400,
                'message' => 'Product does not pushed to shopify'
            ];
        } else {
            return [
                'status' => 200,
                'message' => 'saved',
                'response' => json_encode($response)
            ];
        }
    }

    public function delete_from_shopify($retailer_product_id)
    {

        $retailerProduct = RetailerProduct::find($retailer_product_id);

        $shop = ShopifyApp::shop();

        $response = $shop->api()->rest('DELETE', '/admin/api/2019-10/products/' . $retailerProduct->shopify_product_id . '.json');

        $retailerProduct->toShopify = 0;
        $retailerProduct->shopify_product_id = null;
        $retailerProduct->save();

        if ($response->errors) {
            return [
                'status' => 400,
                'message' => 'Error while deleting product.',
                'response' => json_encode($response)
            ];
        } else {
            return [
                'status' => 200,
                'message' => 'Product has been deleted from your shopify.',
                'response' => json_encode($response)
            ];
        }
    }

    public function set_shopify_product_status(Request $request,$retailer_product_id){
        $retailerProduct = RetailerProduct::find($retailer_product_id);

        $shop = ShopifyApp::shop();
        if($request->input('published') == 'true'){
            $published = true;
            $status =1;
        }
        else{
            $published = false;
            $status =0;
        }
        $productData = [
            "product" => [
                'published' =>$published
            ]
        ];

        $response = $shop->api()->rest('PUT', '/admin/api/2019-10/products/' . $retailerProduct->shopify_product_id . '.json',$productData);

        $retailerProduct->status = $status;
        $retailerProduct->save();
        if ($response->errors) {
            return [
                'status' => 400,
                'message' => 'Error while updating status of product.',
                'response' => json_encode($response)
            ];
        } else {
            return [
                'status' => 200,
                'message' => 'Product Status has been updated in your shopify store',
                'response' => json_encode($response)
            ];
        }
    }

    public function manage_products()
    {
        $productsCount = Product::all()->count();

        $products = '';

        if ($productsCount > 28) {
            $products = Product::take(28)->orderBy('created_at', 'desc')->get();
        } else {
            $products = Product::orderBy('created_at', 'desc')->all();
        }

        $categories = Category::take(12)->get();
        $all_categories = Category::take(30)->get();
        return view('products.manage_products', compact('products', 'categories', 'all_categories'));
    }

    //adding single supplier product to import list
    public function import_single_product(Request $request, $id)
    {
        $user = Auth::user();
        $markup_settings = MarkupSetting::where('user_id', $user->id)->first();

        if ($markup_settings == null) {
            $markup_settings->user_id = $user->id;
            $markup_settings->ask_every_time = true;
            $markup_settings->save();
        }
        $percentage = $request->input('percentage');
        $fixed = $request->input('fixed');

        $checkIfRetailerHasAlreadyAddedProduct = RetailerProduct::where('product_id', $id)->where('retailer_id', $user->id)->first();

//            dd($checkIfRetailerHasAlreadyAddedProduct);
        if ($checkIfRetailerHasAlreadyAddedProduct == null) {
            //create a retailer's copy of product

            $product = Product::find($id);//find actual product
            Product::whereId($id)->update(["sold_count" => intval($product->sold_count) + 1]);

            $retailer_product = new RetailerProduct(); //create new retailer product
            $retailer_product->product_id = $product->id;
            $retailer_product->retailer_id = Auth::id();
            $retailer_product->title = $product->title;
            $retailer_product->body_html = $product->body_html;
            $retailer_product->toShopify = false;
            $retailer_product->cost = $product->price; //price of supplier product is the cost for retailer product

            //add profit margin set by retailer to its product price
            if ($markup_settings->ask_every_time == 0) {
                //if markup price has been set already
                if ($markup_settings->type == 'percentage') {
                    $retailer_product->price = $product->price + (($product->price / 100) * $markup_settings->value);
                } else if ($markup_settings->type == 'fixed') {
                    $retailer_product->price = $product->price + $markup_settings->value;
                } else if ($markup_settings->type == 'multiplier') {
                    $retailer_product->price = $product->price * $markup_settings->value;
                }
            } else if ($markup_settings->ask_every_time == 1) {
                //when user has set to ask for price each time
                if ($percentage != null) {
                    $price = floatval($product->price + (($product->price / 100) * $percentage));
                } else {
                    $price = $product->price + $fixed;
                }
                $retailer_product->price = $price; //price includes the profit margin set by retailer
            }

            $retailer_product->sku = $product->sku;
            $retailer_product->barcode = $product->barcode;
            $retailer_product->vendor = $product->vendor;
            $retailer_product->grams = $product->grams;
            $retailer_product->option1 = $product->option1;
            $retailer_product->value1 = $product->value1;
            $retailer_product->option2 = $product->option2;
            $retailer_product->value2 = $product->value2;
            $retailer_product->option3 = $product->option3;
            $retailer_product->value3 = $product->value3;
            $retailer_product->type = $product->type;
            $retailer_product->handle = $product->handle;
            $retailer_product->image = $product->image;
            $retailer_product->tags = $product->tags;
            $retailer_product->status = 1;

            $retailer_product->save();

            $productOptions = Option::where('product_id', $product->id)->get();

            foreach ($productOptions as $productOption) {
                $option = new RetailerProductOption();
                $option->retailer_product_id = $retailer_product->id;
                $option->name = $productOption->name;
                $option->position = $productOption->position;
                $option->values = $productOption->values;
                $option->save();
            }

            $product_variants = ProductVariants::where('product_id', $product->id)->get();

            foreach ($product_variants as $product_variant) {

                $retailer_product_variant = new RetailerProductVariant();
                $retailer_product_variant->retailer_product_id = $retailer_product->id;
                $retailer_product_variant->grams = $product_variant->grams;
                $retailer_product_variant->title = $product_variant->title;
                $retailer_product_variant->sku = $product_variant->sku;
                $retailer_product_variant->option1 = $product_variant->option1;
                $retailer_product_variant->option2 = $product_variant->option2;
                $retailer_product_variant->option3 = $product_variant->option3;
                $retailer_product_variant->weight = $product_variant->weight;
                $retailer_product_variant->weight_unit = $product_variant->weight_unit;
                $retailer_product_variant->cost = $product_variant->price;

                //add profit margin set by retailer to its product price
                if ($markup_settings->ask_every_time == 0) {
                    //if markup price has been set already
                    if ($markup_settings->type == 'percentage') {
                        $retailer_product_variant->price = $product->price + (($product->price / 100) * $markup_settings->value);
                    } else if ($markup_settings->type == 'fixed') {
                        $retailer_product_variant->price = $product->price + $markup_settings->value;
                    } else if ($markup_settings->type == 'multiplier') {
                        $retailer_product_variant->price = $product->price * $markup_settings->value;
                    }
                } else if ($markup_settings->ask_every_time == 1) {
                    //when user has set to ask for price each time
                    if ($percentage != null) {
                        $price = floatval($product->price + (($product->price / 100) * $percentage));
                    } else {
                        $price = $product->price + $fixed;
                    }
                    $retailer_product_variant->price = $price; //price includes the profit margin set by retailer
                }

                $retailer_product_variant->quantity = $product_variant->quantity;
                $retailer_product_variant->barcode = $product_variant->barcode;
                $retailer_product_variant->src = $product_variant->src;
                $retailer_product_variant->shopify_image_id = $product_variant->shopify_image_id;
                $retailer_product_variant->local_shopify_variant_id = $product_variant->shopify_variant_id;

                $retailer_product_variant->save();
            }

            $productImages = ProductImage::where('product_id', $product->id)->get();

            foreach ($productImages as $productImage) {
                $retailer_product_image = new RetailerProductImage();
                $retailer_product_image->retailer_product_id = $retailer_product->id; //link image with product

                if (isset($retailer_product_variant) && $retailer_product_variant != null) {
                    $retailer_product_image->retailer_product_variant_id = $retailer_product_variant->id;
                }
                $retailer_product_image->shopify_image_id = $productImage->shopify_image_id;
                $retailer_product_image->isVariant = $productImage->isVariant;
                $retailer_product_image->alt = $productImage->alt;
                $retailer_product_image->position = $productImage->position;
                $retailer_product_image->height = $productImage->height;
                $retailer_product_image->width = $productImage->width;
                $retailer_product_image->src = $productImage->src;
                $retailer_product_image->variant_ids = $productImage->variants_ids;
                $retailer_product_image->save();
            }
            $retailer_product->save();
        } else {
            return [
                'status' => 201,
                'message' => 'You have already imported this product'
            ];
        }
        return [
            'status' => 200,
            'message' => 'Your selected product has been added to import list successfully'
        ];
    }

    public function product_change_variant_image(Request $request){
        $product_image = RetailerProductImage::find($request->image_id);
        $productVariant = RetailerProductVariant::find($request->variant_id);
        if($product_image != null && $productVariant != null){

            $existing_image = RetailerProductImage::find($productVariant->image_id);
            if($existing_image != null){
                $existing_image->variant_id = null;
                $existing_image->save();
            }

            $productVariant->retailer_product_image_id = $product_image->id;
            $productVariant->shopify_image_id = $product_image->shopify_image_id;
            $productVariant->src = $product_image->src;
            $productVariant->save();

            $variant_array  = json_decode($product_image->variant_ids);

            if(!in_array($productVariant->shopify_variant_id,$variant_array)){
                array_push($variant_array,$productVariant->shopify_variant_id);
                $product_image->variant_ids = json_encode($variant_array);
            }
            $product_image->retailer_product_variant_id = $productVariant->id;
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

    public function import_list(Request $request)
    {
        $retailer_drafts = RetailerProduct::where('retailer_id', Auth::user()->id)
            ->where('toShopify', '=', false)
            ->orderBy('created_at', 'desc')
            ->newQuery();
        if($request->has('filter-by-name')){
            $retailer_drafts->where('title','LIKE','%'.$request->input('filter-by-name').'%');
        }
        $retailer_drafts =$retailer_drafts->paginate(30);
        $pageType = 'import list';
        $queryName = $request->input('filter-by-name');

        return view('retailer.imported_products.index',
            compact('retailer_drafts', 'pageType','queryName'));
    }
}
