<?php

namespace App\Helpers;

use App\User;
use OhMyBrew\ShopifyApp\ShopifyApp;

class ShopifyHelper
{

    public $user;

    public function __construct()
    {
        $shop = ShopifyApp::shop();
        dd($shop);
    }

    public static function get_authenticated_user()
    {
        $shop = ShopifyApp::shop();
        if ($shop != null){
            $user = User::where('myshopify_domain', $shop->shopify_domain)->first();
        }

    }
}
