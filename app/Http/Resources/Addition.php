<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Addition extends JsonResource
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
            'service_id' => $this->service_id,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}
