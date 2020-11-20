<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'receiver_id', 'order_id', 'last_message', 'is_seen', 'deleted_from'
    ];

    public function ChatMessages()
    {
        return $this->hasMany('App\Models\Chat', 'conversation_id');
    }

    public function Sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function Receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }

    public function Order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}
