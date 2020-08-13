<?php

namespace App\Http\Controllers;

use App\SupplierSetting;
use App\SupplierStores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-view|product-create|product-edit|product-delete', ['only' => ['index', 'showProducts']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function showProducts()
    {
        return redirect('/products');
    }

    public function product_add_request_all_pairs(Request $request)
    {
        $array1 = $request->input('array1');
        $array2 = $request->input('array2');
        $array3 = $request->input('array3');

        if ($array1 != null && $array2 == null && $array3 == null) {
            return [
                'status' => 'success',
                'pairs' => $array1
            ];
        } else if ($array2 != null && $array1 == null && $array3 == null) {

            return [
                'status' => 'success',
                'pairs' => $array2
            ];

        } else if ($array3 != null && $array1 == null && $array2 == null) {

            return [
                'status' => 'success',
                'pairs' => $array3
            ];

        } else if ($array2 == null && $array3 != null && $array1 != null) {
            $combinations = self::get_combinations(
                array('item1' => $array1, 'item2' => $array3,)
            );
            return [
                'status' => 'success',
                'pairs' => $combinations
            ];

        } else if ($array3 == null && $array2 != null && $array1 != null) {
            $combinations = self::get_combinations(
                array('item1' => $array1, 'item2' => $array2,)
            );
            return [
                'status' => 'success',
                'pairs' => $combinations
            ];
        } else if ($array1 == null && $array2 != null && $array3 != null) {
            $combinations = self::get_combinations(
                array('item1' => $array2, 'item2' => $array3)
            );
            return [
                'status' => 'success',
                'pairs' => $combinations
            ];
        } else if ($array1 != null && $array2 != null && $array3 != null) {
            $combinations = self::get_combinations(
                array(
                    'item1' => $array1,
                    'item2' => $array2,
                    'item3' => $array3,
                )
            );
            return [
                'status' => 'success',
                'pairs' => $combinations
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Invalid input'
            ];
        }


    }

    function get_combinations($arrays)
    {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }

    public function shipping_settings(Request $request)
    {
        $shipping_price = $request->input('shipping_price');
        $shipping_estimate = $request->input('shipping_estimate');
        $supplier_id = Auth::id();

        $supplier_settings = SupplierSetting::firstOrCreate(['supplier_id' => $supplier_id]);


        $supplier_settings->shipping_price = $shipping_price;
        $supplier_settings->shipping_estimate = $shipping_estimate;

        $supplier_settings->save();

        return back()->with('success', 'Shipping settings has been saved successfully');
    }
}
