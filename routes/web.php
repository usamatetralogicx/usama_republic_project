<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/home', function () {
//    return view('welcome');
//})->middleware(['auth.shop'])->name('home');

Route::get('clear-cache', 'HomeController@bari_command');
Route::get('reset-all', 'HomeController@reset_all');

Route::get('settings', 'HomeController@settings_page')->name('settings');
Route::post('supplier_subscribe', 'HomeController@supplier_subscribe')->name('settings.supplier.subscribe');
Route::post('supplier_set_subscription', 'HomeController@supplier_set_subscription')->name('settings.supplier.set.subscription');
Route::post('supplier_set_restriction', 'HomeController@set_restrictions')->name('settings.supplier.set.restrictions');
Route::post('/update-info/admin', 'HomeController@updateAdminInfo')->name('settings.admin.info.update');
Route::post('/update-info/supplier', 'HomeController@updateSupplierInfo')->name('settings.supplier.info.update');
Route::post('/update-pw/supplier', 'HomeController@updateSupplierPassword')->name('settings.supplier.password.update');

Route::get('supplier/{supplier_id}/store/{store_id}/detach', 'HomeController@detach_store_supplier')->name('settings.detach.supplier.store');


/**
 * Login Route(s)
 */
Route::get('user/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('user/login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
/**
 * Register Route(s)
 */
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
/**
 * Password Reset Route(s)
 */
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
/**
 * Email Verification Route(s)
 */
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

Route::get('check/permissions', 'HomeController@permissions');
Route::get('check/role', 'HomeController@role');


//Route::group(['middleware' => ['auth.shop']], function (){});


Route::group(['middleware' => ['auth']], function () {

    //payment gateway STRIPE
    Route::post('user/payment/{order_id}', 'PaymentController@payment')->name('payment');
    Route::post('add/user/payment', 'PaymentController@store')->name('payment.store');
    Route::get('create/stripe/customer', 'PaymentController@create_stripe_customer')->name('create.stripe.customer');
    Route::get('get/stripe/customer', 'PaymentController@get_stripe_customer')->name('stripe.customer');
    Route::get('remove/payment-method/{id}', 'PaymentController@remove_payment_method')->name('remove.payment.method');

    //admin routes
    Route::prefix('admin')->group(function () {
        Route::get('products', 'AdminController@showProducts')->name('admin.products');
        Route::get('product/{product_id}/change-status', 'AdminController@changeProductStatus')->name('admin.change.product.status');
        Route::get('manage/products', 'AdminController@manageProducts')->name('admin.manage.products');
        Route::post('assign/products', 'AdminController@assignProducts')->name('admin.assign.category');
        Route::post('de/assign/sub-category', 'AdminController@deAssignProducts')->name('admin.de-assign.subcategory');
        Route::get('dashboard', 'HomeController@index')->name('admin.dashboard');
        Route::get('subcategories/{category_id}', 'AdminController@subcategories');

        Route::resource('categories', 'CategoryController');
        Route::resource('sub_categories', 'SubCategoryController');


        //store
        Route::get('store', 'AdminController@stores')->name('admin.stores');

        //orders
        Route::get('orders', 'AdminController@orders')->name('admin.orders');
        Route::get('orders/with-details/{supplier_id}', 'AdminController@orders_with_details')->name('admin.orders.with.details');

        //retailers
        Route::get('retailers', 'AdminController@retailers')->name('admin.retailers');
        Route::get('retailer/{retailer_id}', 'AdminController@retailer')->name('admin.retailer');
        Route::get('order/{order_id}/supplier', 'AdminController@supplier_orders')->name('admin.order.supplier');
        Route::get('order/{order_id}/retailer', 'AdminController@retailer_orders')->name('admin.order.retailer');

        //suppliers
        Route::get('suppliers', 'AdminController@suppliers')->name('admin.suppliers');
        Route::get('supplier/{supplier_id}', 'AdminController@supplier')->name('admin.supplier');
        Route::get('supplier/{supplier_id}/change-status', 'AdminController@changeSupplierStatus')->name('admin.change.supplier.status');
        Route::post('supplier/{supplier_id}/trail-extension', 'AdminController@trail_extension')->name('admin.change.supplier.trail');
        Route::get('supplier/{supplier_id}/free-user', 'AdminController@FreeUserStatus')->name('admin.change.supplier.free.status');


        //Payments
        Route::get('payments', 'AdminController@payments')->name('admin.payments');
        Route::get('reset', 'AdminController@reset_show')->name('admin.reset');

        //sales reports
        Route::get('sales/reports', 'ReportController@sales_reports')->name('admin.sales.reports');



    });

    //supplier routes
    Route::group(['middleware' => ['CheckSupplierSubscription']], function () {
        Route::prefix('supplier')->group(function () {
            Route::get('products', 'SupplierController@showProducts')->name('supplier.products.index');
            Route::post('product/add/request/for/all/pairs', 'SupplierController@product_add_request_all_pairs')->name('supplier.request.all.pairs');

            //manage store
            Route::get('stores', 'SupplierStoresController@stores')->name('supplier.stores');
            Route::get('store/create', 'SupplierStoresController@showCreateStoreForm')->name('supplier.store.create');
            Route::post('store/create', 'SupplierStoresController@create_store')->name('supplier.store.create');
            Route::get('store/delete/{id}', 'SupplierStoresController@delete_store')->name('supplier.store.delete');
            Route::get('store/edit/{id}', 'SupplierStoresController@edit_store')->name('supplier.store.edit');
            Route::post('store/update/{id}', 'SupplierStoresController@update_store')->name('supplier.store.update');
            Route::get('store/sync/products/{store_id}', 'SupplierStoresController@store_sync_products')->name('supplier.store.sync.products');
            Route::post('store/set/profit/margin/{store_id}', 'SupplierStoresController@store_set_profit_margin')->name('supplier.store.set.profit.margin');


            Route::post('product/variant/add/image/{variant_id}', 'ProductController@product_add_variant_image')->name('supplier.product.add.variant.image');
            Route::get('product/variant/{variant_id}/change/image/{image_id}', 'ProductController@product_change_variant_image')->name('supplier.product.change.variant.image');

            Route::get('variant/delete/{id}', 'ProductController@destroyVariant')->name('supplier.variant.destroy');
            Route::get('product/image/delete/{image_id}', 'ProductController@destroyProductImage')->name('supplier.product.image.delete');
            Route::get('manage/products', 'ProductController@mange_products')->name('supplier.manage.products');

            //manage orders
            Route::get('orders', 'SupplierOrderController@index')->name('supplier.orders');
            Route::get('orders/with-details', 'SupplierOrderController@orders_with_details')->name('supplier.orders.with.details');
            Route::get('order/{order_id}', 'SupplierController@show')->name('supplier.order');

            Route::post('add/fulfillment/tracking/{fulfillment_id}', 'SupplierOrderController@add_tracking_details')->name('supplier.add.fulfillment.tracking');

            Route::get('fulfillment/{order_id}', 'SupplierOrderController@fulfillments')->name('supplier.fulfillments');
            Route::post('fulfillment/fulfill/{order_id}', 'SupplierOrderController@fulfill_order')->name('supplier.fulfill.order');


            //manage setting routes
            Route::post('shipping/settings', 'SupplierController@shipping_settings')->name('supplier.shipping.settings');

        });

    });

    //retailer routes
    Route::prefix('retailer')->group(function () {
        Route::get('all/products', 'ProductController@index')->name('retailer.all.available.products');;
        Route::get('products', 'RetailerProductController@index')->name('retailer.products');
        Route::get('products/import-list', 'RetailerProductController@import_list')->name('retailer.imported.products');
        Route::get('product/delete/{product_id}', 'RetailerProductController@destroy')->name('retailer.product.destroy');
        Route::post('products/bulk/delete', 'RetailerProductController@bulk_destroy')->name('retailer.bulk.product.destroy');
        Route::get('products/show/{id}', 'RetailerProductController@show')->name('retailer.products.show');
        Route::get('products/edit/{id}', 'RetailerProductController@edit')->name('retailer.products.edit');
        Route::put('products/update/{id}', 'RetailerProductController@update')->name('retailer.products.update');
//        Route::post('add/products/to/draft', 'RetailerProductController@store')->name('retailer.add.products.to.draft');
        Route::post('add/products/to/import-list', 'RetailerProductController@store')->name('retailer.add.products.to.draft');

        Route::post('add/product-to-draft/{product_id}', 'RetailerProductController@import_single_product')->name('retailer.add.product.to.draft');
        Route::post('product/push/to/shopify/{retailer_product_id}', 'RetailerProductController@push_to_shopify')->name('retailer.product.push.to.shopify');
        Route::post('products/push/to/shopify', 'RetailerProductController@push_products_to_shopify')->name('retailer.products.push.to.shopify');
        Route::get('product/delete/from/shopify/{retailer_product_id}', 'RetailerProductController@delete_from_shopify')->name('retailer.product.delete.from.shopify');
        Route::post('product/variant/add/image/{variant_id}', 'RetailerProductController@product_add_variant_image')->name('retailer.product.add.variant.image');
        Route::get('variant/delete/{id}', 'RetailerProductController@destroyVariant')->name('retailer.variant.destroy');
        Route::get('product/image/delete/{image_id}', 'RetailerProductController@destroyProductImage')->name('retailer.product.image.delete');
        Route::get('manage/products', 'RetailerProductController@manage_products')->name('retailer.manage.products');
        Route::get('product/variant/{variant_id}/change/image/{image_id}', 'RetailerProductController@product_change_variant_image')->name('retailer.product.change.variant.image');


        Route::get('product/status/from/shopify/{retailer_product_id}', 'RetailerProductController@set_shopify_product_status')->name('retailer.product.set.from.shopify');


        //retailer orders
        Route::get('orders', 'RetailerOrderController@index')->name('retailer.orders');
        Route::get('orders/with-details', 'RetailerOrderController@orders_with_details')->name('retailer.orders.with.details');
        Route::get('orders/all/sync', 'RetailerOrderController@storeOrdersComingFromShopify')->name('retailer.orders.all.sync');
        Route::get('order/{order_id}', 'RetailerOrderController@show')->name('retailer.order');
        Route::post('assign/orders/to/suppliers/{order_id}', 'RetailerOrderController@assign_order_to_suppliers')->name('retailer.assign.order.to.suppliers');


        //retailer settings
        Route::post('retailer/account/update', 'RetailerController@account')->name('retailer.account.update');


    });

    //common routes

    Route::resource('roles', 'RoleController');
//    Route::resource('users', 'UserController');
    Route::resource('products', 'ProductController');

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('product/delete/{product_id}', 'ProductController@destroy')->name('product.delete');

    Route::get('search/products', 'ProductController@search_products')->name('search.products');

    //show individual product details
    Route::get('product/{product_id}', 'ProductController@show')->name('product.show');

    //get products by categories
    Route::get('category/{category_id}/products', 'ProductController@productsByCategory')->name('products.by.category');

    //get products by sub-category
    Route::get('search/products/{subcategory_id}/sub-category/', 'ProductController@show_by_subcategory')->name('products.show.by.sub-category');

    //get products by filter
    Route::get('/search/products/filter-by/{filter_id}', 'ProductController@show_products_by_filter')->name('products.show.by.filter');

    //get products by filter and category
    Route::get('search/products/category/{category_id}/filter-by/{filter_id}', 'ProductController@show_products_by_filter_and_category')->name('products.show.by.filter.and.category');

    //get products by filter and sub-category
    Route::get('/search/products/sub-category/{sub_category_id}/filter-by/{filter_id}', 'ProductController@show_products_by_filter_and_sub_category')->name('products.show.by.filter.and.sub-category');

    Route::post('markup/settings', 'MarkupSettingController@save')->name('markup.settings');

});


Route::get('delete/order/{id}', 'WebhookController@deleteOrder');
Route::get('test', 'WebhookController@test');
Route::get('details', 'WebhookController@details');
Route::get('test/supplier/orders', 'WebhookController@supplierOrders');
Route::get('all/webhooks', 'WebhookController@all_webhooks');
Route::get('delete/all/webhooks', 'WebhookController@delete_all_webhooks');
Route::get('test-product', 'ProductController@test_product_filter');
Route::get('add/sub-category', 'WebhookController@add_sub_categories');
Route::get('user-payment-methods', 'SandboxController@payment_methods_of_user');


