<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDelegateNotification extends Model
{

    protected $fillable = ['order_id', 'delegate_id'];

}
