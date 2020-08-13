<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductLocation extends Model
{
    protected $fillable = [
        'product_id',
        'name'
    ];
}
