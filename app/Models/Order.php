<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'provider_id', 'delegate_id', 'category_id', 'order_category_type', 'order_status', 'delivery_price', 'total_order_price',
        'app_precentage_from_provider', 'has_provider_delegate', 'book_date', 'lat', 'lng', 'retrieve_step', 'app_price_from_provider',
        'is_deliverable','last_notify','details'
    ];

    public function Provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Delegate()
    {
        return $this->belongsTo(User::class, 'delegate_id');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function OrderServices()
    {
        return $this->hasMany(OrderService::class, 'order_id');
    }

    public function BookingOrder()
    {
        return $this->hasOne(BookingOrder::class, 'order_id');
    }
}
