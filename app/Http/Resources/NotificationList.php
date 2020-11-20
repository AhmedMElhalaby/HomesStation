<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationList extends JsonResource
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
            'key' => $this->key,
            'key_id' => $this->key_id,
            'is_seen' => $this->is_seen,
            'body' => $this['msg_' . app()->getLocale()],
            'time' => $this->created_at->diffforhumans(),
        ];
    }
}
