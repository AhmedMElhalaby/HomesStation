<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'message_type' => $this->message_type,
            'message_position' => $this->sender_id == $request->user('api')->id ? 'current' : 'other',
            'sender_data' => [
                'id' => $this->sender_id,
                'username' => $this->Sender->username,
                'profile_image' => $this->Sender->profile_image,
            ],
            'message' => $this->message_value,
            'created_at' => $this->created_at->diffforhumans(),
        ];
    }
}
