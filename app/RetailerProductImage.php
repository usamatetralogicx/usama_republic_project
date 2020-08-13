<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerProductImage extends Model
{
    protected $fillable = [
        'retailer_product_id',
        'shopify_image_id',
//        'local_shopify_image_id',
        'isVariant',
        'alt',
        'position',
        'height',
        'width',
        'src',
        'variant_ids',
    ];

    public function variants()
    {
        return $this->belongsToMany('App\RetailerProductVariant');
    }

    public function product()
    {
        $this->belongsTo('App\RetailerProduct');
    }

    public function shopify_variants(){
        return $this->hasMany('App\RetailerProductImage', 'shopify_image_id','shopify_image_id');

    }
}
