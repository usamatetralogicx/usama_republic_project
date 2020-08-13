<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OhMyBrew\ShopifyApp\Models\Shop;

class Product extends Model
{
    protected $fillable = [
        'shopify_product_id',
        'title',
        'body_html',
        'vendor',
        'sku',
        'barcode',
        'type',
        'grams',
        'tags',
        'option1',
        'value1',
        'option2',
        'value2',
        'option3',
        'value3',
        'fromShopify',
        'status', //true for active, false for inactive
        'handle',
        'image',
        'shop_id',
        'sold_count',
    ];

    public function variants()
    {
        return $this->hasMany('App\ProductVariants', 'product_id');
    }

    public function linked_retailer_product()
    {
        return $this->hasOne(RetailerProduct::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsToMany(User::class, 'user_products', 'product_id', 'user_id');
    }
    public function linked_supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function sub_categories()
    {
        return $this->belongsToMany('App\SubCategory', 'App\ProductCategory', 'product_id');
    }

    public function has_store()
    {
        return $this->belongsTo('App\SupplierStores', 'shop_id');

    }

}
