<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerProductOption extends Model
{
    protected $fillable = [
        'retailer_product_id',
        'name',
        'position',
        'values',
    ];

    public function product()
    {
        return $this->belongsTo('App\RetailerProduct');
    }

}
