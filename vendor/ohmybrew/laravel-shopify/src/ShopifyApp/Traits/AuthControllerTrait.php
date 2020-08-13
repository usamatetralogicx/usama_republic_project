<?php

namespace OhMyBrew\ShopifyApp\Traits;

use http\Client\Curl\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use OhMyBrew\ShopifyApp\Facades\ShopifyApp;
use OhMyBrew\ShopifyApp\Models\Shop;
use OhMyBrew\ShopifyApp\Requests\AuthShop;
use OhMyBrew\ShopifyApp\Services\AuthShopHandler;
use OhMyBrew\ShopifyApp\Services\ShopSession;

/**
 * Responsible for authenticating the shop.
 */
trait AuthControllerTrait
{
    /**
     * Index route which displays the login page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $shopDomain = Request::query('shop');

        return View::make('shopify-app::auth.index', compact('shopDomain'));
    }

    /**
     * Authenticating a shop.
     *
     * @param \OhMyBrew\ShopifyApp\Requests\AuthShop $request The incoming request.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function authenticate(AuthShop $request)
    {
        // Get the validated data
        $validated = $request->validated();
        $shopDomain = ShopifyApp::sanitizeShopDomain($validated['shop']);
        $shop = ShopifyApp::shop($shopDomain);

        // Start the process
        $auth = new AuthShopHandler($shop);
        $session = new ShopSession($shop);
        $session->setDomain($shopDomain);

        if (!$request->filled('code')) {
            // Handle a request without a code, do a fullpage redirect
            // Check if they have offline access, if they do not, this is most likely an install
            // If they do, fallback to using configured grant mode
            $authUrl = $auth->buildAuthUrl(
                $shop->hasOfflineAccess() ?
                    Config::get('shopify-app.api_grant_mode') :
                    ShopSession::GRANT_OFFLINE
            );

            return View::make(
                'shopify-app::auth.fullpage_redirect',
                compact('authUrl', 'shopDomain')
            );
        }

        // We have a good code, get the access details
        $access = $auth->getAccess($validated['code']);
        $session->setAccess($access);

        // Do post processing and dispatch the jobs
        $auth->postProcess();
        $auth->dispatchJobs();

        // Dispatch the events always (for full and partial)
        $auth->dispatchEvent();

        // Go to homepage of app or the return_to
        return $this->returnTo();
    }

    /**
     * Determines where to redirect after successfull auth.
     *
     * @return string
     */
    protected function returnTo()
    {
        // Set in AuthShop middleware
        $return_to = Session::get('return_to');
        if ($return_to) {
            Session::forget('return_to');

            return Redirect::to($return_to);
        }


        $checkIfRetailerOfThisShopAlreadyExist = \App\User::where('shop_id', ShopifyApp::shop()->id)->first();


        if ($checkIfRetailerOfThisShopAlreadyExist != null){
            $retailer = $checkIfRetailerOfThisShopAlreadyExist;

//            return Redirect::route('login', compact('retailer'));
//            dd($retailer);
            return redirect()->route('login')->with('retailer', $retailer);
        } else {
            // create retailer then go to home route

            $shopify_domain = ShopifyApp::shop()->shopify_domain;
            $name = substr($shopify_domain,0,-14);
            $email = $name . '@smokedrop.com';

            $retailer = \App\User::create([
                'email' => $email,
                'myshopify_domain' => $shopify_domain ,
                'name' =>$name,
                'shop_id' => ShopifyApp::shop()->id,
                'status' => 'active',
                'password' => bcrypt($shopify_domain)
            ]);

            $retailer->save();

            $retailer->assignRole('retailer');

            return redirect()->route('login')->with('retailer', $retailer);
        }


    }
}
