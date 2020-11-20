<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Package\PackageList;
use App\Models\Subscription;

class PackageController extends MasterController
{
    public function providers()
    {
        return response(['status' => 'true', 'message' => '', 'data' => PackageList::collection(Subscription::where('user_type', 'providers')->get())], 200);
    }
    
    public function delegates()
    {
        return response(['status' => 'true', 'message' => '', 'data' => PackageList::collection(Subscription::where('user_type', 'delegates')->get())], 200);
    }
}
