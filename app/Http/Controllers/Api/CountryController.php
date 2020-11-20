<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Country as CountryResource;
use App\Models\Country;

class CountryController extends MasterController
{
    public function index()
    {
        return response(['status' => 'true', 'message' => '', 'data' => CountryResource::collection(Country::all())], 200);
    }
}
