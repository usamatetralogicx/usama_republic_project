<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierOrderLineItem extends Model
{
    protected $fillable = [
        'supplier_order_id',
        'retailer_product_variant_id',
        'shopify_line_item_id',
        'shopify_product_id',
        'shopify_variant_id',
        'title',
        'quantity',
        'fulfilled_quantity',
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

    public function order()
    {
        return $this->belongsTo(SupplierOrder::class, 'supplier_order_id');
    }

    public function retailer_product_variant()
    {
        return $this->belongsTo(RetailerProductVariant::class, 'retailer_product_variant_id');
    }


}
