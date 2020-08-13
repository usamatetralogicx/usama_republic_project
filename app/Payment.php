<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'object',
        'brand',
        'last4',
        'card_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
