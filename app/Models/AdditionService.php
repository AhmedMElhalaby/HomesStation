<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionService extends Model
{
    protected $table = 'additions_service';

    protected $fillable = ['service_id', 'name', 'price'];

    public function Service()
    {
        return $this->belongsTo('App\Models\Service');
    }
}
