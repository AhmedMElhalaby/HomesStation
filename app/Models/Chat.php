<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\General\ImageController;

class Chat extends Model
{
    protected $table = 'chats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'conversation_id', 'message_type', 'message', 'deleted_from'
    ];

    protected $appends = ['message_value'];

    public function Conversation()
    {
        return $this->belongsTo('App\Models\Conversation', 'conversation_id');
    }

    public function Sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function setMessageAttribute($value){
        if ($this->attributes['message_type'] == "image") {
            $filename = ImageController::upload_single($value, 'app/uploads/chat/images');
            $this->attributes['message'] = $filename;
        } else if ($this->attributes['message_type'] == "voice_message") {
            $filename = generate_code() . '_' . time() . '.' . $value->getClientOriginalExtension();
            $value->move(public_path('storage/app/uploads/chat/voice_message'), $filename);
            $this->attributes['message'] = $filename;
        } else {
            $this->attributes['message'] = $value;
        }
    }

    public function getMessageValueAttribute()
    {
        if ($this->attributes['message_type'] == "image") {
            if (!file_exists(public_path('storage/app/uploads/chat/images/300' . "/" . $this->attributes['message']))) {
                return trans('app.deleted_file');
            }
            return asset('storage/app/uploads/chat/images/300') . '/' . $this->attributes['message'];
        } else if($this->attributes['message_type'] == "voice_message") {
            if (!file_exists(public_path('storage/app/uploads/chat/voice_message' . "/" . $this->attributes['message']))) {
                return trans('app.deleted_file');
            }
            return asset('storage/app/uploads/chat/voice_message') . '/' . $this->attributes['message'];
        }else{
            return $this->attributes['message'];
        }
    }
}
