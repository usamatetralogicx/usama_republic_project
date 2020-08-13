<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkupSetting extends Model
{
    protected $fillable = [
        'user_id',
        'value',
        'type',
        'ask_every_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
