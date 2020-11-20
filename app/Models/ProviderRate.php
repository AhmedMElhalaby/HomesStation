<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ProviderRate extends Model
{
    protected $table = 'provider_rates';

    protected $fillable = ['user_id', 'provider_id', 'order_id', 'rate', 'reason'];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
