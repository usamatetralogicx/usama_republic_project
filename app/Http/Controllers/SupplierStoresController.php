<?php

namespace App\Http\Controllers;

use App\SupplierStores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SupplierStoresController extends Controller
{

    public function stores()
    {
        $supplier = Auth::user();
        $supplier_stores = SupplierStores::where('supplier_id', $supplier->id)->paginate(15);
        return view('store.index', compact('supplier_stores'));
    }

    public function showCreateStoreForm()
    {
        return view('store.create');
    }

    public function create_store(Request $request)
    {
        $store = new SupplierStores();

        $store->shop_domain = $request->input('shop_domain');
        $store->api_key = $request->input('api_key');
        $store->password = $request->input('password');
        $store->shared_secret = $request->input('shared_secret');
        $store->supplier_id = Auth::user()->id;

        if ($store->save()) {
            return back()->with('success', 'Store has been saved.');
        }
    }

    public function edit_store($id)
    {
        $store = SupplierStores::find($id);

        return view('store.edit', compact('store'));
    }

    public function update_store(Request $request, $id)
    {
        $store = SupplierStores::find($id);

        $store->shop_domain = $request->input('shop_domain');
        $store->api_key = $request->input('api_key');
        $store->password = $request->input('password');
        $store->shared_secret = $request->input('shared_secret');


        if ($store->save()) {
            return redirect()->route('supplier.stores')->with('success', 'Store details has been updated.');
        }
    }

    public function delete_store($id)
    {

        $store = SupplierStores::find($id);

        if ($store->delete()) {
            return back()->with('success', 'Store has been deleted successfully');
        } else {
            return back()->with('error', 'Unable to delete store');

        }
    }

    public function store_sync_products($id)
    {
        $shop = SupplierStores::find($id);
        $response = ['status' => 500, 'message' => 'error'];

        $sh = App::make('ShopifyAPI');
        $sh->setup(['API_KEY' => $shop->api_key, 'API_SECRET' => $shop->shared_secret, 'SHOP_DOMAIN' => $shop->shop_domain, 'ACCESS_TOKEN' => $shop->password]);
        $sh->installURL(['permissions' => array('read_products')]);

        $count = $sh->call([
            'METHOD' => 'GET',
            'URL' => '/admin/products/count.json'
        ]);

        $product_count = $count->count;
        $pages = (integer)ceil($product_count / 250);
        for ($i = 1; $i <= $pages; $i++) {
            $products = $sh->call([
                'METHOD' => 'GET',
                'URL' => '/admin/products.json?limit=250&page=' . $i,
            ]);

            $products = $products->products;
            $productController = new ProductController();
            $response = $productController->storeProductComingFromShopify($products, $id);
        }

        return $response;
    }

    public function store_set_profit_margin(Request $request, $id)
    {
        $percentage = $request->input('percentage');
        $fixed = $request->input('fixed');

        $store = SupplierStores::find($id);


        if ($percentage != null) {
            $store->profit_margin_percentage = $percentage;
        } else if ($fixed != null) {
            $store->profit_margin_fixed = $fixed;
        }

        if ($store->save()) {
//        dd($store);
            return [
                'status' => 200,
                'message' => 'saved'
            ];
        } else {
            return [
                'status' => 400,
                'message' => 'not saved'
            ];
        }
    }

}
