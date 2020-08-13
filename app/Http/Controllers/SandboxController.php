<?php

namespace App\Http\Controllers;

use App\Payment;
use App\RetailerOrder;
use App\SupplierOrderFulfillment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SandboxController extends Controller
{
    public function sandbox($order_id)
    {
        $retailer_order = RetailerOrder::find($order_id);
        $supplier = Auth::user();

        $linked_supplier_orders = $retailer_order->supplier_order;

        $supplier_orders = [];

        foreach ($linked_supplier_orders as $supplier_order) {
            if ($supplier_order->supplier_id == $supplier->id) {
                array_push($supplier_orders, $supplier_order);
            }
        }

        return view('orders.fulfillments.index', compact('supplier_orders'));
    }

    public function fulfill_order(Request $request, $order_id)
    {
        $retailer_order = RetailerOrder::find($order_id);
        $supplier = Auth::user();

        $linked_supplier_orders = $retailer_order->supplier_order;
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

        $orderItemsCount = count($supplier_orders[0]->hasLineItems);
        $fulFilledItemsCount = 0;

        foreach ($supplier_orders[0]->hasLineItems as $lineItem) {
            if ($lineItem->quantity == 0) {
                $fulFilledItemsCount++;
            }
        }

        if ($orderItemsCount == $fulFilledItemsCount) {
            $supplier_orders[0]->order_status = 1; // 1 means order is completed successfully
            $supplier_orders[0]->fulfillment_status = 'fulfilled';
            $supplier_orders[0]->save();
        }


        $fulfillment = new SupplierOrderFulfillment();
        $fulfillment->supplier_order_id = $supplier_order->id;
        $fulfillment->supplier_id = Auth::id();
        $fulfillment->line_items = json_encode($line_items_array);
        $fulfillment->line_items = json_encode($line_items_array, JSON_FORCE_OBJECT);
        $totalNoOfFulfillments = count($supplier_order->fulfillments);
        $fulfillment->name = $supplier_order->retailer_order->name . '.' . ++$totalNoOfFulfillments;

        $fulfillment->save();


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

    public function payment_methods_of_user()
    {
        $user = Auth::user();
        dd($user->payment_methods);

//        dd(Payment::first()->user);
    }


}
