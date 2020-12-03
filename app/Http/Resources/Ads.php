<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ads extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $bt = \App\Models\BankTransfer::where('type','pay_advertising_fees')->where('type_id',$this->id)->first();
        $tr = \App\Models\Transactions::where('type','pay_advertising_fees')->where('type_id',$this->id)->first();

        return [
            'id' => $this->id,
            'desc' => $this->desc,
            'image' => $this->image400,
            'counter_views' => $this->counter_views,
            'counter_clicks' => $this->counter_clicks,
            'provider_data' => new MiniProviderResource($this->User),
            'has_paid' => ($bt || $tr)?true:false,
        ];
    }
}
