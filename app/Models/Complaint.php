<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = ['user_id', 'name', 'mobile', 'title', 'message', 'seen'];
}
