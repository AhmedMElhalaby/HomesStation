<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = ['user_id', 'provider_id', 'service_id', 'count','is_deliverable'];

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function Provider()
    {
        return $this->belongsTo('App\User', 'provider_id');
    }

    public function Service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    public function AdditionCart()
    {
        return $this->hasMany('App\Models\AdditionCart', 'cart_id');
    }
}
