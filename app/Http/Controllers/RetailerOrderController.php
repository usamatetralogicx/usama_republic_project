<?php

namespace App\Http\Controllers;

use App\LineItem;
use App\ProductDeleteHistory;
use App\ProductVariants;
use App\RetailerOrder;
use App\RetailerProductVariant;
use App\SupplierOrder;
use App\SupplierOrderDetails;
use App\SupplierOrderLineItem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OhMyBrew\ShopifyApp\Facades\ShopifyApp;

class RetailerOrderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->input('search')) {
            $orders = RetailerOrder::where('retailer_id', Auth::id())
                ->where('name', 'like', '%' . $request->input('search') . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(30);

            // dd($orders);
        } else {
            $orders = RetailerOrder::where('retailer_id', Auth::id())->orderBy('created_at', 'desc')->paginate(30);
        }

        return view('orders.retailer_order_new_index', compact('orders'));
    }

    public function orders_with_details()
    {
        $orders = RetailerOrder::where('retailer_id', Auth::id())->orderBy('id', 'desc')->get();
//        dd($orders);
        $order_with_details = [];


        foreach ($orders as $order) {
            $supplier = '';
            $supplier_product = '';
            $retailer = '';
            $retailer_product = '';
            $details_array = [];
            $line_items = $order->hasLineItems;
//            dd($line_items);
            $details = [];
            foreach ($line_items as $line_item) {
                //gives retailer variant
                $linked_retailer_product_variant = $line_item->linked_retailer_product_variant;


                if ($linked_retailer_product_variant == null) {
                    //if product which is not imported from local database comes
                    $shop = ShopifyApp::shop();
                    Log::error('product not imported from our system');

                    $variant_src = '';
                    $get_variant = $shop->api()->rest('GET', '/admin/api/2019-10/variants/' . $line_item->shopify_variant_id . '.json');
                    if ($get_variant->errors) {
                        continue;
                    } else {

                        $get_image = $shop->api()->rest('GET', '/admin/api/2019-10/products/' . $line_item->shopify_product_id . '/images/' . $get_variant->body->variant->image_id . '.json');
                        if ($get_image->errors) {
                            if ($get_image->errors) {
                                $variant_src = env('APP_URL') . '/images/placeholder.png';
                            } else {
                                $variant_src = $get_image->body->image->src;
                            }
                        } else {

                            $details = [
                                'variant_image' => $get_image->body->image->src,
                                'supplier' => "",
                                'retailer' => Auth::user()->name,
                                'line_item' => $line_item,
                            ];

                        }
                    }

                } else {
                    Log::error('product imported from our system');


                    //gives retailer product
                    $retailer_product = $linked_retailer_product_variant->retailer_product;
                    $retailer = $retailer_product->retailer;
                    $supplier_product = $retailer_product->linked_supplier_product;
                    if ($supplier_product != null) {
                        $supplier = $supplier_product->supplier;
                    }
                    $variant_image = $linked_retailer_product_variant->image;

                    if ($variant_image == null) {
                        $variant_image = $retailer_product->image;
                    }


                    if ($supplier != null) {
                        $supplier_name = $supplier[0]->name;
                    } else {
                        $supplier_name = null;
                    }
                    $details = [
                        'variant_image' => $variant_image,
                        'supplier' => $supplier_name,
//                    'supplier_product' => $supplier_product,
                        'retailer' => $retailer->name,
//                    'retailer_product' => $retailer_product,
                        'line_item' => $line_item,
                    ];
                    array_push($details_array, $details);
                }

            }
            $orderAndDetails = [
                'order' => $order,
                'order_details' => $details_array
            ];
            array_push($order_with_details, $orderAndDetails);
        }

        $noOfOrdersIncludesProductImportedFromOurSite = 0;
        foreach ($order_with_details as $check) {
            if ($check['order_details'] != null) {
                $noOfOrdersIncludesProductImportedFromOurSite++;
            }
        }


//        dd($order_with_details);
        return view('orders.index_detailed', compact('order_with_details', 'noOfOrdersIncludesProductImportedFromOurSite'));
    }

    public function show($id)
    {
        $order = RetailerOrder::find($id);
        $line_items = $order->hasLineItems;
        $details_array = [];
        $order_with_details = [];
        $fulfilledCount = 0;
        $unfulfilledCount = 0;

        foreach ($line_items as $line_item) {

            //gives retailer variant
            $linked_retailer_product_variant = RetailerProductVariant::where('shopify_variant_id', $line_item->shopify_variant_id)->first();

            if ($linked_retailer_product_variant == null) {
                //if product which is not imported from local database comes
                $shop = ShopifyApp::shop();
                $variant_src = '';

                if ($shop == null) {
                    $variant_src = '/images/placeholder.png';

                } else {
                    $get_variant = $shop->api()->rest('GET', '/admin/api/2019-10/variants/' . $line_item->shopify_variant_id . '.json');
                    if ($get_variant->errors) {

                        continue;
                    } else {

                        $get_image = $shop->api()->rest('GET', '/admin/api/2019-10/products/' . $line_item->shopify_product_id . '/images/' . $get_variant->body->variant->image_id . '.json');
                        if ($get_image->errors) {
                            //variant does not have associated image
                            Log::error('Error while fetching variant images');
                            $get_product_level_images = $shop->api()->rest('GET', '/admin/api/2019-10/products/' . $line_item->shopify_product_id . '/images.json');

                            if ($get_product_level_images->errors) {
                                Log::error('Error while fetching product level image');
                                $variant_src = env('APP_URL') . '/images/placeholder.png';
                            } else {
                                $variant_src = $get_product_level_images->images[0]->src;
                            }
                        } else {
                            Log::error('Variant image fetched from shopify');
                            $variant_src = $get_image->body->image->src;
                        }
                    }
                }

                $details = [
                    'variant_image' => $variant_src,
                    'supplier' => "",
                    'retailer' => Auth::user()->name,
                    'line_item' => $line_item,
                ];

            } else {

                //gives retailer product
                $retailer_product = $linked_retailer_product_variant->retailer_product;
                $retailer = $retailer_product->retailer;
                $supplier_product = $retailer_product->linked_supplier_product;

                if ($supplier_product != null) {
                    $supplier = $supplier_product->supplier;
                    $variant_image = $linked_retailer_product_variant->image;

                    if ($variant_image == null) {
                        $retailer_product_images = $retailer_product->images;
                        $variant_image = $retailer_product_images[0]->src;
                        if ($variant_image == null) {
                            $variant_image = env('APP_URL') . '/images/placeholder.png';
                        }
                    }

                    $details = [
                        'variant_image' => $variant_image,
                        'supplier' => $supplier[0]->name,
                        'retailer' => $retailer->name,
                        'line_item' => $line_item,
                        'deleted_product' => false
                    ];
                } else {
                    //no we dont have the supplier version of this product in database

                    $product_deleted_json = ProductDeleteHistory::where('product_id', $retailer_product->product_id)->first();

                    //check if this product exists in deleted products
                    if ($product_deleted_json != null) {
                        //yes we have this product in deleted products
                        $deleted_product = json_decode($product_deleted_json->product);
                        $supplier = User::find($deleted_product->products->supplier_id);

                        //check if we still have the data of this product's supplier
                        if ($supplier != null) {
                            //yes we sill have the supplier's data
                            $variant_image = $linked_retailer_product_variant->image;


                            if ($variant_image == null) {
                                $retailer_product_images = $retailer_product->images;
                                $variant_image = $retailer_product_images[0]->src;
                                if ($variant_image == null) {
                                    $variant_image = env('APP_URL') . '/images/placeholder.png';
                                }
                            }

                            $details = [
                                'variant_image' => $variant_image,
                                'supplier' => $supplier->name,
                                'retailer' => $retailer->name,
                                'line_item' => $line_item,
                                'deleted_product' => true
                            ];
                        }
                    }
                }

            }
            array_push($details_array, $details);

            if (($line_item->quantity - $line_item->fulfillable_quantity) > 0) {
                $fulfilledCount = $fulfilledCount + ($line_item->quantity - $line_item->fulfillable_quantity);
            } else if (($line_item->quantity - $line_item->fulfillable_quantity) == 0) {
                $unfulfilledCount = $unfulfilledCount + ($line_item->fulfillable_quantity);
            }

            if (($line_item->quantity - $line_item->fulfillable_quantity) != 0) {
                $unfulfilledCount = $unfulfilledCount + ($line_item->fulfillable_quantity);
            }
        }
        $orderAndDetails = [
            'order' => $order,
            'order_details' => $details_array
        ];
        array_push($order_with_details, $orderAndDetails);

        $order_with_details['unfulfilledItemsCount'] = $unfulfilledCount;
        $order_with_details['fulfilledItemsCount'] = $fulfilledCount;
        $fulfillments = json_decode($order->fulfillments, true);

        /*
         * Handling fulfilled items from fulfillment
         */
        $complete_fulfillment = [];
        foreach ($fulfillments as $index => $fulfillment) {
            if ($fulfillment['status'] != 'cancelled') {
                $fulfillment_name = $order_with_details[0]['order']->name . ' - F' . substr($fulfillment['name'], strlen($order_with_details[0]['order']->name) + 1);
                $fulfilled_items_array = [];
                $fulfilledItemsCount = 0;
                foreach ($fulfillment['line_items'] as $line_item) {
                    foreach ($order_with_details[0]['order_details'] as $item) {
                        if ($line_item['id'] == $item['line_item']->shopify_line_item_id) {
                            $fulfilledItemsCount = $fulfilledItemsCount + $line_item['quantity'];

                            $item['line_item_id'] = $line_item['id'];
                            $item['fulfilled_quantity'] = $line_item['quantity'];
                            $item['fulfilled_price'] = $line_item['price'];

                            array_push($fulfilled_items_array, $item);
                        }
                    }
                }
                $complete_fulfillment_details = [
                    'fulfillment_name' => $fulfillment_name,
                    'fulfillment_item_count' => $fulfilledItemsCount,
                    'fulfilled_items' => $fulfilled_items_array
                ];
                array_push($complete_fulfillment, $complete_fulfillment_details);
            }
        }


        $order_with_details[0]['fulfillments'] = $complete_fulfillment;
//        dd($order_with_details);

        return view('orders.show_old')->with([
            'order_with_details' => $order_with_details
        ]);
    }

    //sync orders from shopify
    public function storeOrdersComingFromShopify()
    {

        $shop = ShopifyApp::shop();
        $count = $shop->api()->rest('GET', '/admin/orders/count.json');
        $response = [
            'status' => 500,
            'message' => "Error"
        ];


        $orders_count = $count->body->count;

        if ($orders_count == 0) {
            $response = [
                'status' => 200,
                'message' => 'No Order found on your store'
            ];
        }
        $pages = (integer)ceil($orders_count / 250);
        for ($i = 1; $i <= $pages; $i++) {
            $orders = $shop->api()->rest('GET', '/admin/api/2019-10/orders.json', null, [
                'limit' => 250,
                'page' => $i,
            ]);


            if ($orders->errors) {
                $response = [
                    'status' => $orders->status,
                    'message' => $orders->body
                ];
                break;
            }

            $orders = $orders->body->orders;

            //sync shopify orders here
            foreach ($orders as $order) {

                $checkIfOrderAlreadyImported = RetailerOrder::all()->where('shopify_order_id', $order->id)->last();
                if ($checkIfOrderAlreadyImported != null) {
                    $response = [
                        'status' => 222,
                        'message' => "Order already imported"
                    ];

//                    $newOrder = RetailerOrder::where('shopify_order_id', $order->id)->first();
                }

                if ($checkIfOrderAlreadyImported == null) {
                    $response = [
                        'status' => 200,
                        'message' => "Order Importing"
                    ];
                    //its a new order fetch it
                    $newOrder = new RetailerOrder();
                    $newOrder->shopify_order_id = $order->id;
                    $newOrder->retailer_id = Auth::id();

                    $newOrder->email = $order->email;
                    $newOrder->line_items = json_encode($order->line_items);
                    $newOrder->closed_at = $order->closed_at;
                    $newOrder->shopify_created_at = $order->created_at;
                    $newOrder->shopify_updated_at = $order->updated_at;
                    $newOrder->number = $order->number;
                    $newOrder->note = $order->note;
                    $newOrder->token = $order->token;
                    $newOrder->gateway = $order->gateway;
                    $newOrder->total_price = $order->total_price;
                    $newOrder->subtotal_price = $order->subtotal_price;
                    $newOrder->total_weight = $order->total_weight;
                    $newOrder->total_tax = $order->total_tax;
                    $newOrder->taxes_included = $order->taxes_included;
                    $newOrder->financial_status = $order->financial_status;
                    $newOrder->confirmed = $order->confirmed;
                    $newOrder->currency = $order->currency;
                    $newOrder->total_discounts = $order->total_discounts;
                    $newOrder->total_line_items_price = $order->total_line_items_price;
                    $newOrder->buyer_accepts_marketing = $order->buyer_accepts_marketing;
                    $newOrder->cancelled_at = $order->cancelled_at;
                    $newOrder->name = $order->name;
                    $newOrder->referring_site = $order->referring_site;
                    $newOrder->landing_site = $order->landing_site;
                    $newOrder->cancel_reason = $order->cancel_reason;
                    $newOrder->total_price_usd = $order->total_price_usd;
                    $newOrder->user_id = $order->user_id;
                    $newOrder->phone = $order->phone;
                    $newOrder->app_id = $order->app_id;
                    $newOrder->order_number = $order->order_number;
                    $newOrder->payment_gateway_names = json_encode($order->payment_gateway_names);
                    $newOrder->fulfillment_status = $order->fulfillment_status;
                    $newOrder->processing_method = $order->processing_method;
                    $newOrder->tax_lines = json_encode($order->tax_lines);
                    $newOrder->contact_email = $order->contact_email;
                    $newOrder->order_status_url = $order->order_status_url;
                    $newOrder->total_line_items_price_set = json_encode($order->total_line_items_price_set);
                    $newOrder->total_price_set = json_encode($order->total_price_set);
                    $newOrder->shipping_lines = json_encode($order->shipping_lines);
                    if (isset($order->billing_address)) {
                        $newOrder->billing_address = json_encode($order->billing_address);
                    }
                    if (isset($order->shipping_address)) {
                        $newOrder->shipping_address = json_encode($order->shipping_address);
                    }
                    if (isset($order->fulfillments)) {
                        $newOrder->fulfillments = json_encode($order->fulfillments);
                    }
                    if (isset($order->customer)) {
                        $newOrder->customer = json_encode($order->customer);
                        $newOrder->full_name = $order->customer->first_name . ' ' . $order->customer->last_name;
                    } else {
                        $newOrder->full_name = 'No Customer';
                    }
                    $newOrder->sync_status = true;
                    $newOrder->save();


                    //order created, check if this order container any product imported with our database
                    foreach (json_decode($newOrder->line_items, true) as $item) {

                        $lineItem = new LineItem();
                        $lineItem->shopify_line_item_id = $item['id'];
                        $lineItem->shopify_product_id = $item['product_id'];
                        $variant_for_linking = RetailerProductVariant::where('shopify_variant_id', $item['variant_id'])->first();

                        if ($variant_for_linking != null) {
                            $lineItem->retailer_product_variant_id = RetailerProductVariant::where('shopify_variant_id', $item['variant_id'])->first()->id;
                        }
                        $lineItem->retailer_order_id = $newOrder->id;

                        $lineItem->shopify_variant_id = $item['variant_id'];
                        $lineItem->title = $item['title'];
                        $lineItem->quantity = $item['quantity'];
                        $lineItem->variant_title = $item['variant_title'];
                        $lineItem->sku = $item['sku'];
                        $lineItem->vendor = $item['vendor'];
                        $lineItem->fulfillment_service = $item['fulfillment_service'];
                        $lineItem->requires_shipping = $item['requires_shipping'];
                        $lineItem->taxable = $item['taxable'];
                        $lineItem->gift_card = $item['gift_card'];
                        $lineItem->name = $item['name'];
                        $lineItem->properties = json_encode($item['properties']);
                        $lineItem->fulfillable_quantity = $item['fulfillable_quantity'];
                        $lineItem->price = $item['price'];
                        $lineItem->fulfillment_status = $item['fulfillment_status'];
                        $lineItem->save();
                    }
                    $response = [
                        'status' => 200,
                        'message' => "Order Imported"
                    ];
                }
            }
        }


        if ($response['status'] == 200) {
            return back()->with('success', $response['message']);
        } else if ($response['status'] == 222) {
            return back()->with('info', 'Orders are synced already');
        } else if ($response['status'] == 500) {
            return back()->with('error', 'Error while syncing orders');
        } else {
            return back()->with('warning', 'Something went wrong');
        }
    }

    //assign order to suppliers
    public function assign_order_to_suppliers(Request $request, $id)
    {
        $retailer_order = RetailerOrder::find($id);
        $order_items = $retailer_order->hasLineItems;
        $suppliers_array = []; //array stores the id of those supplier who's products are in the current order

        foreach ($order_items as $order_item) {
            if ($order_item->linked_retailer_product_variant != null) {
                if ($order_item->linked_retailer_product_variant->retailer_product->linked_supplier_product == null) {
                    continue;
                }
                $supplier_id = $order_item->linked_retailer_product_variant->retailer_product->linked_supplier_product->supplier->first()->id;
                if (!in_array($supplier_id, $suppliers_array)) {
                    array_push($suppliers_array, $supplier_id);
                }

                $supplier_order = SupplierOrder::where('supplier_id', $supplier_id)
                    ->where('retailer_order_id', $retailer_order->id)
                    ->first();

                if ($supplier_order == null) {
                    $supplier_order = new SupplierOrder();
                    $supplier_order->supplier_id = $supplier_id;
                    $supplier_order->retailer_order_id = $retailer_order->id;
                    $supplier_order->financial_status = $retailer_order->financial_status;
                    $supplier_order->fulfillment_status = $retailer_order->fulfillment_status;
                }

                $supplier_order->note = $request->input('note_to_supplier');
                $supplier_order->save();

                $supplier_order_line_item = new SupplierOrderLineItem();
                $supplier_order_line_item->supplier_order_id = $supplier_order->id;
                $supplier_order_line_item->retailer_product_variant_id = $order_item->retailer_product_variant_id;
                $supplier_order_line_item->shopify_line_item_id = $order_item->shopify_line_item_id;
                $supplier_order_line_item->shopify_product_id = $order_item->shopify_product_id;
                $supplier_order_line_item->shopify_variant_id = $order_item->shopify_variant_id;
                $supplier_order_line_item->title = $order_item->title;
                $supplier_order_line_item->quantity = $order_item->quantity;
                $supplier_order_line_item->variant_title = $order_item->variant_title;
                $supplier_order_line_item->sku = $order_item->sku;
                $supplier_order_line_item->vendor = $order_item->vendor;
                $supplier_order_line_item->fulfillment_service = $order_item->fulfillment_service;
                $supplier_order_line_item->requires_shipping = $order_item->requires_shipping;
                $supplier_order_line_item->taxable = $order_item->taxable;
                $supplier_order_line_item->gift_card = $order_item->gift_card;
                $supplier_order_line_item->name = $order_item->name;
                $supplier_order_line_item->properties = $order_item->properties;
                $supplier_order_line_item->fulfillable_quantity = $order_item->fulfillable_quantity;

                $supplier_variant = ProductVariants::where('sku', $order_item->linked_retailer_product_variant->sku)
                    ->first();
                $supplier_variant->quantity = $supplier_variant->quantity - $order_item->fulfillable_quantity;

                if ($supplier_variant->quantity < 1) {
                    $supplier_variant->quantity = 0;
                }

                $supplier_variant->save();
                $order_item->linked_retailer_product_variant->save();
                $supplier_order_line_item->price = $order_item->price;
                $supplier_order_line_item->fulfillment_status = $order_item->fulfillment_status;
                $supplier_order_line_item->save();
            }
        }

        $retailer_order->send_to_supplier = 1;

        $retailer_order->save();

        return back()->with('success', 'Order has been sent to supplier successfully');
    }
}
