<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    protected $table = 'order_services';

    protected $fillable = ['order_id', 'service_id', 'count', 'service_price', 'total_price'];

    public function Service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function AdditionOrderService()
    {
        return $this->hasMany(AdditionOrderService::class, 'order_service_id');
    }
}
