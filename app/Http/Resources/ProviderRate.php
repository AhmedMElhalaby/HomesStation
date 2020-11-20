<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderRate extends JsonResource
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
            'user_data' => new MiniUserResource($this->User),
            'rate' => $this->rate,
            'reason' => $this->reason,
            'created_time' => $this->created_at->diffforhumans(),
        ];
    }
}
