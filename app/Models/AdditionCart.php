<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionCart extends Model
{
    protected $table = 'additions_cart';

    protected $fillable = ['cart_id', 'addition_id', 'count'];

    public function Addition()
    {
        return $this->belongsTo('App\Models\AdditionService', 'addition_id');
    }
}
