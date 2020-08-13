<?php

namespace App\Http\Controllers;

use App\Payment;
use App\PaymentHistory;
use App\ProductVariants;
use App\RetailerOrder;
use App\SupplierOrder;
use App\SupplierOrderLineItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentMethod;

class PaymentController extends Controller
{
    // Store method is used to save a payment method if not already saved
    public function store(Request $request)
    {
        $user = Auth::user();
//        $payment_method = $user->payment_method;
//
//        if ($payment_method != null) {
//            return back()->with('error', 'You can only have a single card at a time.');
//        } else {
            $token = $request->input('reservation')['stripe_token'];
            $object = $request->input('object');
            $last4 = $request->input('last4');
            $brand = $request->input('brand');
            \Stripe\Stripe::setApiKey(env('SECRET_KEY'));

            if ($user->stripe_customer_id == null) {
                $name = $user->name;
                $email = $user->email;
                $description = "Smokedrop customer";
                $metadata = ['user_id' => $user->id];



                $stripe_customer = \Stripe\Customer::create([
                    'description' => $description,
                    'name' => $name,
                    'email' => $email,
                    'metadata' => $metadata,
                    'source' => $token,
                ]);

                Log::critical($stripe_customer->id);
                Log::critical($stripe_customer['id']);
                $user->stripe_customer_id = $stripe_customer->id;
                if($user->save()){
                    Log::critical('stripe customer id has been saved');
                    Log::critical($user);

                } else {
                    Log::critical('stripe customer id can not be saved');
                    Log::critical($user);
                }
            } else {
                //adding new source/card and associating it with customer
                $customer_card = \Stripe\Customer::createSource(
                    $user->stripe_customer_id,
                    ['source' => $token]
                );
            }

            $payment_method = new Payment();
            $payment_method->token = $token;
            $payment_method->object = $object;
            $payment_method->last4 = $last4;
            $payment_method->brand = $brand;
            $payment_method->user_id = $user->id;
//            $payment_method->card_token = $customer_card->id;

            if ($payment_method->save()) {
                return back()->with('success', 'New payment method has been added successfully');
            } else {
                return back()->with('error', 'Payment method is not saved');
            }
//        }
    }

    //charge for payment and assign order to supplier
    public function payment(Request $request, $order_id)
    {

        $user = Auth::user();

        $payment_method_id = $request->input('payment_method');
        $payment_amount = $request->input('payable_amount');

        $payment_method = Payment::find($payment_method_id);

        \Stripe\Stripe::setApiKey(env('SECRET_KEY'));

        try {

            $transaction = \Stripe\Charge::create(array(
                "amount" => $payment_amount * 100, // by default stripe made transactions in cents, that's why we multiply it with 100 to convert it in dollars
                "currency" => "usd",
//                "source" => $payment_method->token,
                'customer' => $user->stripe_customer_id,
                "description" => "A payment made on Smokedrop"
            ));



            $retailer_order = RetailerOrder::find($order_id);
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

                    $supplier_variant = ProductVariants::where('shopify_variant_id', $order_item->linked_retailer_product_variant->local_shopify_variant_id)
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

            $payment_history = new PaymentHistory();
            $payment_history->retailer_order_id = $order_id;
            $payment_history->charge_token = $transaction->id;
            $payment_history->transaction_amount = ($transaction->amount / 100);
            $payment_history->balance_transaction = $transaction->balance_transaction;
            $payment_history->customer_token = $transaction->customer;
            $payment_history->receipt_url = $transaction->receipt_url;
            $payment_history->payment_method = $transaction->payment_method;
            $payment_history->save();

            Log::critical($transaction);
            return back()->with('success', 'Payment done successfully !');
        } catch (\Exception $e) {
            Log::critical($e);
            return back()->with('error', 'Error! Please Try again.');
        }
    }

//    public function create_stripe_customer(Request $request)
//    {
//        $user = Auth::user();
//
//        if ($user->stripe_customer_id == null) {
//            $name = $user->name;
//            $email = $user->email;
//            $description = "Smokedrop customer";
//            $metadata = ['user_id' => $user->id];
//
//            \Stripe\Stripe::setApiKey(env('SECRET_KEY'));
//
//            $stripe_customer = \Stripe\Customer::create([
//                'description' => $description,
//                'name' => $name,
//                'email' => $email,
//                'metadata' => $metadata,
//                'source' => 'tok_',
//            ]);
//
////            dd($stripe_customer);
//
//            $user->stripe_customer_id = $stripe_customer->id;
//            $user->save();
//
//            return $stripe_customer;
//        }
//
//    }

    public function get_stripe_customer()
    {
        $user = Auth::user();

        if ($user->stripe_customer_id != null) {
            \Stripe\Stripe::setApiKey(env('SECRET_KEY'));

//            $stripe_customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
            $stripe_customer = \Stripe\Customer::createSource(
                $user->stripe_customer_id,
                ['source' => 'tok_mastercard']
            );
            return $stripe_customer;
        } else {
            return [
                'status' => 201,
                'message' => 'No customer id',
            ];
        }


    }

    public function remove_payment_method($id)
    {
        $user = Auth::user();
        $payment_method = PaymentMethod::find($id);

        if ($payment_method == null){
            return back()->with('info', 'You don\'t have any payment method associated with your account');
        }


        \Stripe\Stripe::setApiKey(env('SECRET_KEY'));

        $stripe_customer =  $stripe_customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
        $default_source_card = $stripe_customer->default_source;
        $stripe_customer = \Stripe\Customer::deleteSource(
            $user->stripe_customer_id,
            $default_source_card
        );

        Log::critical($stripe_customer);

        if ($payment_method->delete()) {
            return back()->with('success', 'Payment method has been removed from your account successfully.');
        } else {
            return back()->with('error', 'Payment method is not removed.');
        }

    }
}
