<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerOrder extends Model
{
    protected $fillable = [
        'retailer_id',
        'shopify_order_id',
        'email',
        'full_name',
        'line_items',
        'closed_at',
        'shopify_created_at',
        'shopify_updated_at',
        'number',
        'note',
        'token',
        'gateway',
        'total_price',
        'subtotal_price',
        'total_weight',
        'total_tax',
        'taxes_included',
        'financial_status',
        'confirmed',
        'currency',
        'total_discounts',
        'total_line_items_price',
        'buyer_accepts_marketing',
        'cancelled_at',
        'name',
        'referring_site',
        'landing_site',
        'cancel_reason',
        'total_price_usd',
        'phone',
        'app_id',
        'order_number',
        'payment_gateway_names',
        'order_number',
        'fulfillment_status',
        'fulfillments',
        'processing_method',
        'tax_lines',
        'contact_email',
        'order_status_url',
        'total_line_items_price_set',
        'total_price_set',
        'shipping_lines',
        'billing_address',
        'shipping_address',
        'customer',
        'sync_status',
        'send_to_supplier',
    ];

    public function retailer(){
        return $this->belongsTo('App\User','retailer_id');
    }

    public function has_retailer_products(){
        return $this->hasMany('App\RetailerProduct','retailer_product_id');
    }

    public function hasLineItems()
    {
        return $this->hasMany('App\LineItem');
    }

    public function supplier_orders()
    {
        return $this->hasMany(\App\SupplierOrder::class, 'retailer_order_id');
    }
//    public function supplier_order(){
//        return $this->hasOne(\App\SupplierOrder::class, 'retailer_order_id');
//    }

    public function transactions()
    {
        return $this->hasMany(PaymentHistory::class);
    }
    public function transaction()
    {
        return $this->hasOne(PaymentHistory::class);
    }
}
