<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'shopify_image_id',
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
        return $this->hasMany('App\ProductVariants');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}
