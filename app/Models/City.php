<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = ['name_ar', 'name_en', 'country_id'];

    public function Country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }
}
