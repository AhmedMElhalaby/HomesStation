<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = ['user_id', 'key', 'key_id', 'msg_ar', 'msg_en', 'is_seen'];    
}
