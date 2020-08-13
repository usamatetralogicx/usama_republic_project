<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariants extends Model
{
    protected $fillable = [
        'product_id',
        'image_id',
        'shopify_image_id', //coming from shopify
        'shopify_variant_id', //coming from shopify
        'local_shopify_variant_id', //coming from shopify
        'title',
        'sku',
        'option1',
        'option2',
        'option3',
        'quantity',
        'grams',
        'weight',
        'weight_unit',
        'cost',
        'price',
        'src',
        'barcode',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function image()
    {
        return $this->belongsTo('App\ProductImage', 'image_id');
    }
}
