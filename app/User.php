<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use OhMyBrew\ShopifyApp\Models\Shop;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'company_name',
        'state',
        'email',
        'phone',
        'gender',
        'password',
        'address',
        'address2',
        'city',
        'country',
        'country_code',
        'currency',
        'money_format',
        'myshopify_domain',
        'shop_id',
        'timezone',
        'zip',
        'status', // (1/true) means active,(0/false) means inactive
        'stripe_customer_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'trial_ends_at' => 'date'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product', 'user_products', 'user_id', 'product_id');
    }

    public function retailer_products()
    {
        return $this->hasMany('App\RetailerProduct', 'retailer_id');
    }

    public function markup_setting()
    {
        return $this->hasOne(MarkupSetting::class);
    }

    public function supplier_setting()
    {
        return $this->hasOne(SupplierSetting::class, 'supplier_id');
    }

    public function fulfillments()
    {
        return $this->hasMany(SupplierOrderFulfillment::class, 'supplier_id');
    }

    public function retailer_orders()
    {
        return $this->hasMany(RetailerOrder::class, 'retailer_id');
    }

    public function supplier_orders()
    {
        return $this->hasMany(SupplierOrder::class, 'supplier_id');
    }

    public function stores()
    {
        return $this->hasMany(SupplierStores::class, 'supplier_id');
    }

    public function payment_method()
    {
        return $this->hasMany(Payment::class);
    }
    public function restricted_stores()
    {
        return $this->belongsToMany(Shop::class, 'shop_supplier', 'supplier_id', 'shop_id');
    }

}
