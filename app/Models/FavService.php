<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavService extends Model
{
    protected $table = 'fav_services';
    protected $fillable = ['user_id', 'service_id'];
}
