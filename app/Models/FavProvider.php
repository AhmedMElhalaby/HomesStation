<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavProvider extends Model
{
    protected $table = 'fav_providers';
    protected $fillable = ['user_id', 'provider_id'];
}
