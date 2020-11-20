<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected$fillable = [
        'role_ar', 'role_en', 'plan',
    ];

    public function setPlanAttribute($value)
    {
        if ($value != '*') {
            $this->attributes['plan'] = json_encode($value);
        }
    }

    public function getPlanAttribute()
    {
        if ($this->attributes['plan'] != '*') {
            return json_decode($this->attributes['plan']);
        } else {
            return $this->attributes['plan'];
        }
    }
}
