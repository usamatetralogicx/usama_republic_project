<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerProduct extends Model
{
    protected $fillable = [
        'product_id', //matching with local product
        'retailer_id',
        'shopify_product_id',
        'title',
        'body_html',
        'sku',
        'barcode',
        'vendor',
        'type',
        'grams',
        'tags',
        'option1',
        'value1',
        'option2',
        'value2',
        'option3',
        'value3',
        'image',
        'shop_id',
        'price',
        'cost',
        'handle',
        'status',
        'toShopify',
    ];

    public function variants()
    {
        return $this->hasMany('App\RetailerProductVariant');
    }

    public function linked_supplier_product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function options()
    {
        return $this->hasMany('App\RetailerProductOption');
    }

    public function images()
    {
        return $this->hasMany('App\RetailerProductImage');
    }

    public function retailer()
    {
        return $this->belongsTo('App\User');
    }
}
