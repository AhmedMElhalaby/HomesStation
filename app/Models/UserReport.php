<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserReport extends Model
{
    protected $table = 'user_reports';

    protected $fillable = [
        'user_id', 'key', 'key_id', 'reason'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function KeyData()
    {
        if ($this->attributes['key'] == 'provider') {
            return $this->belongsTo(User::class, 'key_id');
        } elseif ($this->attributes['key'] == 'service') {
            return $this->belongsTo(Service::class, 'key_id');        
        } elseif ($this->attributes['key'] == 'order') {
            return $this->belongsTo(Order::class, 'key_id');
        }
    }
}
