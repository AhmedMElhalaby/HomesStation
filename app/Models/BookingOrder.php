<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingOrder extends Model
{
    protected $table = 'booking_orders';

    protected $fillable = ['order_id', 'service_id', 'service_price'];

    public function Service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // public function AdditionOrderService()
    // {
    //     return $this->belongsToMany(AdditionService::class, 'additions_order_service', 'addition_service_id', 'order_service_id')->withTimestamps()->withPivot([
    //         'count',
    //         'addition_service_price',
    //         'total_price',
    //     ]);
    // }
}
