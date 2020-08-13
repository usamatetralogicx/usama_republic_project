<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierStores extends Model
{
    protected $fillable = [
        'supplier_id',
        'shop_domain',
        'api_key',
        'password',
        'shared_secret',
        'fetch_count',
        'profit_margin_percentage',
        'profit_margin_fixed',
    ];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }
}
