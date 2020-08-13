<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'position',
        'values',
    ];
}
