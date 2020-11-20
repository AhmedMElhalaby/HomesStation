<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Resources\Service as ServiceResource;

class OfferController extends MasterController
{
    public function update(Request $request, $service_id = null)
    {
        if ($service_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.service_id_required'), 'data' => null], 422);
        if (!Service::find($service_id))
            return response()->json(['status' => 'false', 'message' => trans('app.service_not_found'), 'data' => null], 404);
        if (Service::find($service_id)->provider_id != $request->user()->id)
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_modify'), 'data' => null], 404);
        if (!$request->offer_price)
            return response()->json(['status' => 'false', 'message' => trans('app.offer_price_required'), 'data' => null], 422);
        Service::find($service_id)->update(['has_offer' => 'yes', 'offer_price' => $request->offer_price]);
        return response(['status' => 'true', 'message' => '', 'data' => new ServiceResource(Service::find($service_id))], 200);
    }

    public function delete(Request $request, $service_id = null)
    {
        if ($service_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.service_id_required'), 'data' => null], 422);
        if (!Service::find($service_id))
            return response()->json(['status' => 'false', 'message' => trans('app.service_not_found'), 'data' => null], 404);
        if (Service::find($service_id)->provider_id != $request->user()->id)
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_modify'), 'data' => null], 404);
        Service::find($service_id)->update(['has_offer' => 'no', 'offer_price' => 0]);
        return response(['status' => 'true', 'message' => '', 'data' => new ServiceResource(Service::find($service_id))], 200);
    }
}
