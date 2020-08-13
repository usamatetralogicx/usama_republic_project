<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierSetting extends Model
{
    protected $fillable = [
        'supplier_id',
        'shipping_price',
        'shipping_estimate',
    ];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }
}
