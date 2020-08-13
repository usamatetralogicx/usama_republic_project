<?php

namespace App\Http\Controllers;

use App\LineItem;
use App\Product;
use App\ProductDeleteHistory;
use App\RetailerOrder;
use App\RetailerProduct;
use App\RetailerProductVariant;
use App\SupplierOrder;
use App\SupplierOrderFulfillment;
use App\User;
use App\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierOrderController extends Controller
{
    public function index(Request $request)
    {
//        $orders = RetailerOrder::all();
//        $orders_array = [];
//        foreach ($orders as $order) {
//            $supplier_products_array = [];
//            $order_line_items = $order->hasLineItems;
//            $hasSupplierProducts = false;
//            foreach ($order_line_items as $line_item) {
//
//                //check if line item has linking product variant
//                if ($line_item->retailer_product_variant_id != null) {
//                    //yes this product is from our database
//                    $retailer_variant = RetailerProductVariant::find($line_item->retailer_product_variant_id);
//
//                    //check if we have variant of this product exists in our database
//                    if ($retailer_variant != null) {
//                        //yes we have this product variant in out database
//                        $retailer_product = RetailerProduct::find($retailer_variant->retailer_product_id);
//                        $retailer = User::find($retailer_product->retailer_id)->name;
//                        $supplier_product = Product::find($retailer_product->product_id);
//
//                        //check if the supplier still has this product
//                        if ($supplier_product != null) {
//                            //yes the supplier still have this product
//                            $supplier = User::find(UserProduct::where('product_id', $supplier_product->id)->first()->user_id);
//                            if ($supplier->id == Auth::id()) {
//                                array_push($supplier_products_array, [
//                                    'retailer' => $retailer,
//                                    'order' => $order,
//                                    'line_item' => $line_item,
//                                ]);
//                                $hasSupplierProducts = true;
//                            } else {
//                                continue;
//                            }
//                        }
////                        else {
////                            //no the supplier does not have this product
////
////                            $deleted_product_json = ProductDeleteHistory::where('product_id', $retailer_product->product_id)->first();
////
////                            //check product if product is deleted by supplier
////                            if ($deleted_product_json != null) {
////                                //yes this product is from deleted ones
////                                $deleted_product = json_decode($deleted_product_json->product);
////                                $supplier = User::find($deleted_product->products->supplier_id);
////
////                                //check if we still have the data of this product's supplier
////                                if ($supplier != null) {
////                                    //yes we sill have the supplier's data
////                                    //check if the current logged in user is the actual supplier of this product
////                                    if ($supplier->id == Auth::id()) {
////                                        //yes logged in user is the supplier of this product
////                                        array_push($supplier_products_array, [
////                                            'retailer' => $retailer,
////                                            'order' => $order,
////                                            'line_item' => $line_item,
////                                        ]);
////                                        $hasSupplierProducts = true;
////                                    } else {
////                                        //no current logged in user is not the supplier of this product
////                                        //skip it
////                                        continue;
////                                    }
////                                }
////                            }
////                        }
//                    }
//                }
//            }
//
//            //check if we have any order which contains the product of current logged in user
//            if ($hasSupplierProducts) {
//                // yes we have some
//                array_push($orders_array, [
//                    'retailer' => $order->retailer->name,
//                    'order' => $order,
//                    'supplier_products' => $supplier_products_array
//                ]);
//            }
//        }

        $supplier = Auth::user();
        $supplier_orders = SupplierOrder::where('supplier_id', $supplier->id)
            ->orderBy('created_at', 'desc')
            ->newQuery();

        if ($request->input('search')) {
            $supplier_orders = $supplier_orders->whereHas('retailer_order', function($q) use ($request){
                    $q->where('name','like', '%' . $request->input('search') . '%');
                });
        }

        if(request('filter')){
            if($request->input('filter') == 'pending'){
                $supplier_orders->whereNull('fulfillment_status');
            }
            else if($request->input('filter') == 'ordered'){
                $supplier_orders->where('fulfillment_status','fulfilled');
            }
            else if($request->input('filter') == 'shipped'){
                $supplier_orders->whereHas('fulfillments',function ($q) use ($request){
                    return $q->where('tracking_number','!=',"");
                });
            }
            else{

            }
        }

        $supplier_orders = $supplier_orders->paginate(30);

        return view('orders.retailer_order_new_index')->with([
            'orders' => $supplier_orders,
            'queryStatus' => $request->input('filter'),
            'search' => $request->input('search'),
            'userType' => 'supplier'
        ]);
    }

    public function orders_with_details()
    {
        $supplier = Auth::user();
        $orders = SupplierOrder::where('supplier_id', $supplier->id)->get();


        $order_with_details = [];


        foreach ($orders as $index => $order) {

//            dd($order->hasLineItems);
            \Debugbar::info(json_encode($order->hasLineItems));
            $orderDetails = [
                'order' => $order->retailer_order,
                'order_details' => $order->hasLineItems
            ];

            array_push($order_with_details, $orderDetails);
        }


        $pageType = 'supplier';
//        dd($order_with_details);
        return view('orders.index_detailed', compact('order_with_details', 'pageType'));
    }

    public function show($id)
    {
        $order = RetailerOrder::find($id);
//        dd($order);
        $order_retailer_name = User::find($order->retailer_id)->name;
        $line_items = $order->hasLineItems;
        $details_array = [];
        $order_with_details = [];
        $fulfilledCount = 0;
        $unfulfilledCount = 0;

        foreach ($line_items as $key => $line_item) {
            //gives retailer variant
//            $linked_retailer_product_variant = $line_item->linked_retailer_product_variant;
            $linked_retailer_product_variant = RetailerProductVariant::where('shopify_variant_id', $line_item->shopify_variant_id)->first();

//            dd($linked_retailer_product_variant);

            //check if line item has linking product variant
            if ($linked_retailer_product_variant != null) {
                //yes we this line item has linking product variant

                //get the retailer product of this line item
                $retailer_product = $linked_retailer_product_variant->retailer_product;
                $retailer = $retailer_product->retailer;
                $supplier_product = $retailer_product->linked_supplier_product;

                //check if it has supplier product
                if ($supplier_product != null) {
                    //yes supplier product is available in the database
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
                    array_push($details_array, $details);

                    if (($line_item->quantity - $line_item->fulfillable_quantity) > 0) {
                        $fulfilledCount = $fulfilledCount + ($line_item->quantity - $line_item->fulfillable_quantity);
                    } else if (($line_item->quantity - $line_item->fulfillable_quantity) == 0) {
                        $unfulfilledCount = $unfulfilledCount + ($line_item->fulfillable_quantity);
                    }

                    if (($line_item->quantity - $line_item->fulfillable_quantity) != 0) {
                        $unfulfilledCount = $unfulfilledCount + ($line_item->fulfillable_quantity);
                    }
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
                            //check if the current logged in user is the actual supplier of this product
                            if ($supplier->id == Auth::id()) {
                                //yes logged in user is the supplier of this product
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
                                array_push($details_array, $details);

                                if (($line_item->quantity - $line_item->fulfillable_quantity) > 0) {
                                    $fulfilledCount = $fulfilledCount + ($line_item->quantity - $line_item->fulfillable_quantity);
                                } else if (($line_item->quantity - $line_item->fulfillable_quantity) == 0) {
                                    $unfulfilledCount = $unfulfilledCount + ($line_item->fulfillable_quantity);
                                }

                                if (($line_item->quantity - $line_item->fulfillable_quantity) != 0) {
                                    $unfulfilledCount = $unfulfilledCount + ($line_item->fulfillable_quantity);
                                }

                            } else {
                                //no current logged in user is not the supplier of this product
                                //skip it
                                continue;
                            }
                        }
                    }
                }

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


        /**
         * Handling fulfilled items from order_fulfillment
         */
        $complete_fulfillment = [];
        foreach ($fulfillments as $index => $fulfillment) {
            if ($fulfillment['status'] != 'cancelled') {
                $fulfillment_name = $order_with_details[0]['order']->name . ' - F' . substr($fulfillment['name'], strlen($order_with_details[0]['order']->name) + 1);
                $fulfilled_items_array = [];
                $fulfilledItemsCount = 0;

                foreach ($fulfillment['line_items'] as $line_item) {

                    $get_local_line_item = LineItem::where('shopify_line_item_id', $line_item['id'])->first();

                    if ($get_local_line_item != null) {
                        $linked_retailer_product_variant = $get_local_line_item->linked_retailer_product_variant;

                        if ($linked_retailer_product_variant != null) {

                            foreach ($order_with_details[0]['order_details'] as $item) {

                                if ($line_item['id'] == $item['line_item']->shopify_line_item_id) {
                                    $fulfilledItemsCount = $fulfilledItemsCount + $line_item['quantity'];

                                    $item['line_item_id'] = $line_item['id'];
                                    $item['fulfilled_quantity'] = $line_item['quantity'];
                                    $item['fulfilled_price'] = $line_item['price'];

                                    array_push($fulfilled_items_array, $item);
                                }
                                $complete_fulfillment_details = [
                                    'fulfillment_name' => $fulfillment_name,
                                    'fulfillment_item_count' => $fulfilledItemsCount,
                                    'fulfilled_items' => $fulfilled_items_array
                                ];
                                array_push($complete_fulfillment, $complete_fulfillment_details);
                            }
                        }
                    }
                }
            }
        }
        $order_with_details[0]['fulfillments'] = $complete_fulfillment;
        $order_with_details[0]['retailer'] = $order_retailer_name;

//        dd($order_with_details);


        return view('orders.show_supplier_order', compact('order_with_details'));
    }

    public function fulfillments($order_id)
    {
        $retailer_order = RetailerOrder::find($order_id);
        $supplier = Auth::user();

        $linked_supplier_orders = $retailer_order->supplier_orders;

        $supplier_orders = [];

        foreach ($linked_supplier_orders as $supplier_order) {
            if ($supplier_order->supplier_id == $supplier->id) {
                array_push($supplier_orders, $supplier_order);
            }
        }

        // dd($supplier_orders);
        return view('orders.fulfillments.index', compact('supplier_orders'));
    }

    public function fulfill_order(Request $request, $order_id)
    {
        $retailer_order = RetailerOrder::find($order_id);
        $supplier = Auth::user();

        $linked_supplier_orders = $retailer_order->supplier_orders()->where('supplier_id', $supplier->id)->get();
        $supplier_orders = [];
        $order_items_array = [];

        foreach ($linked_supplier_orders as $supplier_order) {
            if ($supplier_order->supplier_id == $supplier->id) {
                array_push($order_items_array, $supplier_order->hasLineItems);
                array_push($supplier_orders, $supplier_order);
            }
        }

        $fulfilled_quantity = $request->input('quantity');

        $line_items_array = [];
        foreach ($order_items_array[0] as $index => $order_line_item) {
            if ($order_line_item->fulfillable_quantity > 0) {

                if ($fulfilled_quantity[$index] > $order_line_item->fulfillable_quantity) {
                    return back()->with('error', 'Select quantity less than ' . $order_line_item->fulfillable_quantity . ' for ' . $order_line_item->retailer_product_variant->retailer_product->title . ' ' . $order_line_item->retailer_product_variant->title);
                }
                if ($fulfilled_quantity[$index] > $order_line_item->fulfillable_quantity) {
                    return back()->with('error', 'Select quantity less than ' . $order_line_item->fulfillable_quantity . ' for ' . $order_line_item->retailer_product_variant->retailer_product->title . ' ' . $order_line_item->retailer_product_variant->title);
                }
                if ($fulfilled_quantity[$index] < 0) {
                    return back()->with('error', 'Select quantity between 1 and ' . $order_line_item->fulfillable_quantity . ' for ' . $order_line_item->retailer_product_variant->retailer_product->title . ' ' . $order_line_item->retailer_product_variant->title);
                }
//
                $order_line_item->fulfilled_quantity = $order_line_item->fulfilled_quantity + $fulfilled_quantity[$index];
                $order_line_item->fulfillable_quantity = $order_line_item->fulfillable_quantity - $fulfilled_quantity[$index];


                if ($order_line_item->fulfillable_quantity == 0) {
                    $order_line_item->fulfillment_status = 'fulfilled';
                }

                $order_line_item->save();

                $order_line_item->fulfilled_quantity =  $fulfilled_quantity[$index];

                if ($fulfilled_quantity[$index] > 0) {
                    array_push($line_items_array, $order_line_item);
                }
            }
        }

        $fulfillment = new SupplierOrderFulfillment();
        $fulfillment->supplier_order_id = $supplier_order->id;
        $fulfillment->supplier_id = Auth::id();
        $fulfillment->line_items = json_encode($line_items_array);
        $fulfillment->line_items = json_encode($line_items_array, JSON_FORCE_OBJECT);
        $totalNoOfFulfillments = count($supplier_order->fulfillments);
        $fulfillment->name = $supplier_order->retailer_order->name . '.' . ++$totalNoOfFulfillments;

        $fulfillment->save();

        $toBeFulfilledItemsCount = 0;
        $fulFilledItemsCount = 0;

        foreach($supplier_orders[0]->hasLineItems as $lineItem){
            $toBeFulfilledItemsCount = $toBeFulfilledItemsCount + $lineItem->quantity;
            $fulFilledItemsCount = $fulFilledItemsCount + ($lineItem->quantity - $lineItem->fulfillable_quantity);
        }

        if ($toBeFulfilledItemsCount == $fulFilledItemsCount) {
            $supplier_orders[0]->order_status = 1; // 1 means order is completed successfully
            $supplier_orders[0]->fulfillment_status = 'fulfilled';
            $supplier_orders[0]->save();
        }

        return back()->with('success', 'Fulfillment has been made successfully');
    }

    public function add_tracking_details(Request $request, $fulfillment_id)
    {
        $fulfillment = SupplierOrderFulfillment::find($fulfillment_id);
        $fulfillment->tracking_number = $request->input('tracking_number');
        $fulfillment->tracking_url = $request->input('tracking_url');
        $fulfillment->tracking_notes = $request->input('tracking_notes');
        $fulfillment->save();

        return back()->with('success', 'Tracking information has been saved');
    }

}
