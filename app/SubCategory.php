<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'category_id',
        'name',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'App\ProductCategory', 'sub_category_id');
    }
}
