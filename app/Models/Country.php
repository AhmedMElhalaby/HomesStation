<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = ['name_ar', 'name_en', 'phonecode'];

    public function Cities()
    {
        return $this->hasMany('App\Models\City', 'country_id');
    }
}
