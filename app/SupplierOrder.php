<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SupplierOrder extends Model
{
    protected $fillable = [
        'supplier_id',
        'retailer_order_id',
        'order_status',
        'financial_status',
        'fulfillment_status',
        'fulfillable_quantity',
        'fulfilled_quantity',
        'fulfilled_quantity',
        'note',
    ];

    public function retailer_order()
    {
        return $this->belongsTo(RetailerOrder::class,  'retailer_order_id', 'id');
    }

    public function hasLineItems()
    {
        return $this->hasMany(SupplierOrderLineItem::class);
    }

    public function fulfillments()
    {
        return $this->hasMany(SupplierOrderFulfillment::class);
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }
}
