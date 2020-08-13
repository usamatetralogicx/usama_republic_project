<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'product_id',
        'sub_category_id',
    ];

    public function category()
    {
        return $this->belongsToMany('App\SubCategory');

    }


}
