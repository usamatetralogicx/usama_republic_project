<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineItem extends Model
{
    protected $fillable = [
        'retailer_order_id',
        'retailer_product_variant_id',
        'shopify_line_item_id',
        'shopify_product_id',
        'shopify_variant_id',
        'title',
        'quantity',
        'variant_title',
        'sku',
        'vendor',
        'fulfillment_service',
        'requires_shipping',
        'taxable',
        'gift_card',
        'name',
        'properties',
        'gift_card',
        'fulfillable_quantity',
        'price',
        'fulfillment_status',
    ];

    public function linked_retailer_product_variant()
    {
        return $this->hasOne('App\RetailerProductVariant' , 'shopify_variant_id','shopify_variant_id');
    }

    public function order()
    {
        return $this->belongsTo(RetailerOrder::class, 'retailer_order_id');
    }

}
