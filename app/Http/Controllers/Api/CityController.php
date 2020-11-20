<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\City as CityResource;
use App\Models\City;

class CityController extends MasterController
{
    public function index($country_id = null)
    {
        if ($country_id == null) {
            return response()->json(['status' => 'false', 'message' => trans('app.country_not_found'), 'data' => null], 422);
        }
        return response(['status' => 'true', 'message' => '', 'data' => CityResource::collection(City::where('country_id', $country_id)->get())], 200);
    }
}
