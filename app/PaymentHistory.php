<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = [
        'retailer_order_id',
        'charge_token',
        'transaction_amount',
        'balance_transaction',
        'customer_token',
        'receipt_url',
        'payment_method'
    ];


    public function order()
    {
        return $this->belongsTo(RetailerOrder::class, 'retailer_order_id');
    }
}
