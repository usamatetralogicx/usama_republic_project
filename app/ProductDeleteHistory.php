<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDeleteHistory extends Model
{
    protected $fillable = [
        'product_id',
        'product',
    ];
}
