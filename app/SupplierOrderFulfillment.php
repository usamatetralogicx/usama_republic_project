<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierOrderFulfillment extends Model
{
    protected $fillable = [
        'supplier_id',
        'supplier_order_id',
        'status',
        'name',
        'line_items',
        'tracking_number',
        'tracking_url',
        'tracking_notes',
    ];

    public function supplier_order()
    {
        return $this->belongsTo(SupplierOrder::class, 'supplier_order_id');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }
}
