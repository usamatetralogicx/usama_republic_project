<?php

namespace App\Http\Controllers;

use App\Helpers\ShopifyHelper;
use App\Product;
use App\ProductImage;
use App\RetailerDraftProduct;
use App\RetailerProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetailerController extends Controller
{
    public function showImportedProducts()
    {
        $user = ShopifyHelper::get_authenticated_user();

        $product_images = ProductImage::all();
        $products = RetailerProduct::latest()->where('retailer_id', $user->id)->paginate(15);

        return view('products.index', compact('products', 'product_images'))
            ->with('i', (request()->input('page', 1) - 1) * 15);

    }

    public function orders()
    {
//        $user = Auth::user();

//        return view('orders.index');
    }

    public function PushToShopify(Request $request)
    {
        $options_count = 0;
        $vendor = $request->input('vendor');
        $type = $request->input('type');
        $item_number = $request->input('item_number');
        $supplier = $request->input('supplier');
        $option_labels = $request->input('option_label');
        $options1 = $request->input('option1');
        $min_qtys = $request->input('min_qtys');
        $custom_options = $request->input('custom_options');
        $min_qtys_array = [];
        $variants = [];
        $options = [];
        $images_array = [];
        foreach ($option_labels as $index => $label) {
            if ($label && $request->input('option_values')[$index]) {
                $options_count = $options_count + 1;
            }
        }
        if ($min_qtys) {
            foreach ($min_qtys as $index => $min_qty) {
                $min_qtys_array[] = $min_qty . '_' . $request->input('min_price')[$index];
            }
        }
        if ($option_labels) {
            if (count($option_labels) >= 1) {
                foreach ($option_labels as $index => $label) {
                    if ($label && $request->input('option_values')[$index]) {
                        array_push($options, [
                            "name" => $label,
                            "values" => explode(',', $request->input('option_values')[$index])
                        ]);
                    }
                }
            }
        }
        foreach ($options1 as $index => $option) {
            if ($options_count == 3) {
                array_push($variants, [
                    "option1" => $option,
                    "option2" => $request->input('option2')[$index],
                    "option3" => $request->input('option3')[$index],
                    "price" => $request->input('price')[$index],
                    'sku' => $request->input('sku')[$index],
                    "weight" => $request->input('weight')[$index],
                    "weight_unit" => "lb",
                ]);
            } else if ($options_count == 2) {
                array_push($variants, [
                    "option1" => $option,
                    "option2" => $request->input('option2')[$index],
                    "price" => $request->input('price')[$index],
                    'sku' => $request->input('sku')[$index],
                    "weight" => $request->input('weight')[$index],
                    "weight_unit" => "lb",
                ]);
            } else {
                array_push($variants, [
                    "option1" => $option,
                    "price" => $request->input('price')[$index],
                    'sku' => $request->input('sku')[$index],
                    "weight" => $request->input('weight')[$index],
                    "weight_unit" => "lb",
                ]);
            }
        }
        if ($request->input('images')) {
            foreach ($request->input('images') as $image) {
                array_push($images_array, [
                    'src' => $image,
                ]);
            }
        }
        $metafields = [];
        if ($item_number) {
            array_push($metafields, [
                "key" => "item_no",
                "value" => $item_number,
                "value_type" => "string",
                "namespace" => "product"
            ]);
        }
        if ($request->input('location_1')) {
            array_push($metafields, [
                "key" => "location_1",
                "value" => $request->input('location_1'),
                "value_type" => "string",
                "namespace" => "imprint"
            ]);
        }
        if ($request->input('location_2')) {
            array_push($metafields, [
                "key" => "location_2",
                "value" => $request->input('location_2'),
                "value_type" => "string",
                "namespace" => "imprint"
            ]);
        }
        if ($request->input('decoration_method')) {
            array_push($metafields, [
                "key" => "methods",
                "value" => $request->input('decoration_method'),
                "value_type" => "string",
                "namespace" => "imprint"
            ]);
        }
        if ($request->input('min_qty')) {
            array_push($metafields, [
                "key" => "min",
                "value" => $request->input('min_qty'),
                "value_type" => "string",
                "namespace" => "price"
            ]);
        }
        if ($min_qtys_array) {
            array_push($metafields, [
                "key" => "breaks",
                "value" => join(',', $min_qtys_array),
                "value_type" => "string",
                "namespace" => "price"
            ]);
        }
        if ($custom_options) {
            array_push($metafields, [
                "key" => "options",
                "value" => $custom_options,
                "value_type" => "string",
                "namespace" => "price"
            ]);
        }
        if ($request->input('pms_fee')) {
            array_push($metafields, [
                "key" => "pms",
                "value" => $request->input('pms_fee'),
                "value_type" => "string",
                "namespace" => "price"
            ]);
        }
        if ($request->input('setup_charge')) {
            array_push($metafields, [
                "key" => "setup",
                "value" => $request->input('setup_charge'),
                "value_type" => "string",
                "namespace" => "price"
            ]);
        }
        if ($request->input('dimension')) {
            array_push($metafields, [
                "key" => "dimension",
                "value" => $request->input('dimension'),
                "value_type" => "string",
                "namespace" => "product"
            ]);
        }
        if ($request->input('price_includes')) {
            array_push($metafields, [
                "key" => "price_includes",
                "value" => $request->input('price_includes'),
                "value_type" => "string",
                "namespace" => "product"
            ]);
        }
        if ($request->input('production_time')) {
            array_push($metafields, [
                "key" => "production_time",
                "value" => $request->input('production_time'),
                "value_type" => "string",
                "namespace" => "product"
            ]);
        }
        if ($request->input('run_charge')) {
            array_push($metafields, [
                "key" => "run_charge",
                "value" => $request->input('run_charge'),
                "value_type" => "string",
                "namespace" => "price"
            ]);
        }
        $data = [
            "product" => [
                "title" => $request->input('title'),
                "body_html" => $request->input('description'),
                "vendor" => $vendor,
                "tags" => 'sage,' . $request->input('tags') . ',' . $vendor . ',' . $type . ',' . $supplier . ',' . $item_number . ',' . $request->input('brand_status'),
                "product_type" => $type,
                "variants" => $variants,
                "options" => $options,
                'images' => $images_array,
                'metafields' => $metafields
            ]
        ];
        $products = $this->helper->getShopify()->call([
            'METHOD' => 'POST',
            'URL' => '/admin/products.json',
            'DATA' => $data
        ]);
        $this->productsController->CreateProduct($products->product, $this->helper->getShop()->shopify_domain);
        $this->productsController->ProductAdditionalInformation($request, $products->product->id, $min_qtys_array, $this->helper->getShop()->shopify_domain, 'sage');
        return view('inc.variants_image')->with([
            'product' => $products->product,
            'db_product' => Product::where('shopify_id', $products->product->id)->first()
        ]);
    }

    public function account(Request $request)
    {
        $name = $request->input('name');
        $user_name = $request->input('user_name');
        $user_email = $request->input('user_email');

        $retailer = Auth::user();

        $retailer->name = $name;
        $retailer->user_name = $user_name;
        $retailer->user_email = $user_email;
        if ($retailer->save()) {
            return back()->with('success', 'Account details has been saved');
        } else {
            return back()->with('error', 'Account details has not saved');
        }
    }

}
