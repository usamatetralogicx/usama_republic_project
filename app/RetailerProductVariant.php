<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerProductVariant extends Model
{
    protected $fillable = [
        'retailer_product_id',
        'retailer_product_image_id',
        'shopify_image_id', //coming from shopify
        'local_shopify_variant_id',
        'shopify_variant_id', //coming from shopify
        'title',
        'sku',
        'option1',
        'option2',
        'option3',
        'quantity',
        'grams',
        'weight',
        'weight_unit',
        'barcode',
        'cost',
        'price',
        'src',
    ];

    public function retailer_product()
    {
        return $this->belongsTo('App\RetailerProduct','retailer_product_id');
    }

    public function retailer_product_image()
    {
        return $this->belongsTo(RetailerProductImage::class,'retailer_product_image_id');
    }

    public function image()
    {
        return $this->belongsTo('App\RetailerProductImage', 'retailer_product_image_id');
    }

    public function shopify_image()
    {
        return $this->hasOne('App\RetailerProductImage', 'shopify_image_id', 'shopify_image_id');
    }

}
