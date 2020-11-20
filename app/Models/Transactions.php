<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    
    protected $fillable = [
        'user_id', 'type', 'type_id', 'transaction_id', 'amount'
    ];
    
    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function Order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
