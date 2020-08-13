<?php

namespace App\Http\Controllers;

use App\Product;
use App\RetailerOrder;
use App\RetailerProduct;
use App\RetailerProductVariant;
use App\User;
use App\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OhMyBrew\ShopifyApp\Facades\ShopifyApp;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::critical('Web-hook test: ' . $request);
    }

    public function supplierOrders()
    {
        $orders = RetailerOrder::all();
        $orders_array = [];
        foreach ($orders as $order) {
            $supplier_products_array = [];
            $order_line_items = $order->hasLineItems;
            $hasSupplierProducts = false;

            foreach ($order_line_items as $line_item) {
                if ($line_item->retailer_product_variant_id != null) {
                    $retailer_variant = RetailerProductVariant::find($line_item->retailer_product_variant_id);
                    $retailer_product = RetailerProduct::find($retailer_variant->retailer_product_id);
                    $retailer = User::find($retailer_product->retailer_id)->name;
                    $supplier_product = Product::find($retailer_product->product_id);
                    $supplier = User::find(UserProduct::where('product_id', $supplier_product->id)->first()->user_id);
                    if ($supplier->id == Auth::id()) {
                        array_push($supplier_products_array, [
                            'retailer' => $retailer,
                            'order' => $order,
                            'line_item' => $line_item,
//                            'supplier_product' => $supplier_product,
//                            'retailer_product' => $retailer_product,
//                            'retailer_variant' => $retailer_variant,
                        ]);
                        $hasSupplierProducts = true;
                    }
                }
            }

            if ($hasSupplierProducts) {
                array_push($orders_array, [
                    'retailer' => $order->has_retailer->name,
                    'order' => $order,
                    'supplier_products' => $supplier_products_array
                ]);
            }
        }

        dd($orders_array);
        return view('orders.index', compact('orders'));
    }

    public function deleteOrder($id)
    {
        $shop = ShopifyApp::shop();

        $response = $shop->api()->rest('DELETE', '/admin/api/2019-10/orders/' . $id . '.json');

        dd($response);
    }

    public function test()
    {
        return view('testpage');
    }

    public function details()
    {
        $orders = RetailerOrder::all();
        $order_with_details = [];

        foreach ($orders as $order) {
            $supplier = '';
            $supplier_product = '';
            $retailer = '';
            $retailer_product = '';
            $details_array = [];

            $line_items = $order->hasLineItems;


            foreach ($line_items as $line_item) {
                //gives retailer variant
                $linked_retailer_product_variant = $line_item->linked_retailer_product_variant;


                if ($linked_retailer_product_variant == null) {
                    //if product which is not imported from local database comes
                    $shop = ShopifyApp::shop();
//                        dd($line_item->shopify_variant_id);
                    $get_variant = $shop->api()->rest('GET', '/admin/api/2019-10/variants/' . $line_item->shopify_variant_id . '.json');
                    $get_image = $shop->api()->rest('GET', '/admin/api/2019-10/products/' . $line_item->shopify_product_id . '/images/' . $get_variant->body->variant->image_id . '.json');
                    if ($get_image->errors) {
                        continue;
                    } else {

                        $details = [
                            'variant_image' => $get_image->body->image->src,
                            'supplier' => "Product not from our site",
                            'retailer' => Auth::user()->name,
                            'line_item' => $line_item,
                        ];
                    }
                } else {

                    //gives retailer product
                    $retailer_product = $linked_retailer_product_variant->retailer_product;
                    $retailer = $retailer_product->retailer;
                    $supplier_product = $retailer_product->linked_supplier_product;
                    $supplier = $supplier_product->supplier;
                    $variant_image = $linked_retailer_product_variant->image;

                    Log::info('RetailerProduct: ' . $retailer_product);
                    Log::info('Retailer: ' . $retailer);
                    Log::info('');

                    Log::info('SupplierProduct: ' . $supplier_product);
                    Log::info('Supplier: ' . $supplier);
                    Log::info('');

                    if ($variant_image == null) {
                        $variant_image = $linked_retailer_product_variant->shopify_image->src;
                    }

                    $details = [
                        'variant_image' => $variant_image,
                        'supplier' => $supplier[0]->name,
//                    'supplier_product' => $supplier_product,
                        'retailer' => $retailer->name,
//                    'retailer_product' => $retailer_product,
                        'line_item' => $line_item,
                    ];

                }


                array_push($details_array, $details);
            }

            $orderAndDetails = [
                'order' => $order,
                'order_details' => $details_array
            ];

            array_push($order_with_details, $orderAndDetails);
        }

        dd($order_with_details);
    }

    public function all_webhooks()
    {
        $shop = ShopifyApp::shop();
        $response = $shop->api()->rest('GET', '/admin/api/2020-01/webhooks.json');
        dd($response);
    }

    public function delete_all_webhooks()
    {
        $shop = ShopifyApp::shop();
        $response = $shop->api()->rest('GET', '/admin/api/2020-01/webhooks.json');
        foreach ($response->body->webhooks as $webhook) {
            $shop->api()->rest('DELETE', '/admin/api/2020-01/webhooks/' . $webhook->id . '.json');
        }
    }

    public function add_sub_categories()
    {
        $toys = [
            'Book Lights',
            'Ceiling Lights & Fans',
            'Commercial Lighting',
            'Holiday Lighting',
            'LED Lamps',
            'LED Lighting',
            'Lamps & Shades',
            'Light Bulbs',
            'Lighting Accessories',
            'Night Lights',
            'Novelty Lighting',
            'Outdoor Lighting',
            'Portable Lighting',
            'Professional Lighting',
        ];
        $category = \App\Category::find(15);

        foreach ($toys as $toy) {
            $subcategory = new \App\SubCategory();
            $subcategory->category_id = $category->id;
            $subcategory->name = $toy;
            $subcategory->save();
        }

        dd("added");
    }

}
