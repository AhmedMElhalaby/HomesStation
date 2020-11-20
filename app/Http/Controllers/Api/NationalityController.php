<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nationality;
use App\Http\Resources\Nationality as NationalityResource;

class NationalityController extends MasterController
{
    public function index()
    {
        return response(['status' => 'true', 'message' => '', 'data' => NationalityResource::collection(Nationality::all())], 200);
    }
}
