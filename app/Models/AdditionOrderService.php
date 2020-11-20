<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionOrderService extends Model
{
    protected $table = 'additions_order_service';

    protected $fillable = ['order_service_id', 'addition_service_id', 'count', 'addition_service_price', 'total_price'];

    public function Addition()
    {
        return $this->belongsTo(AdditionService::class, 'addition_service_id');
    }
}
