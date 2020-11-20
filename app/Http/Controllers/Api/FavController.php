<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FavService;
use App\User;
use App\Http\Resources\MiniServiceResource;
use App\Models\Service;
use App\Models\FavProvider;
use App\Http\Resources\MiniProviderResource;

class FavController extends MasterController
{
    public function index(Request $request)
    {
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $data['services'] = MiniServiceResource::collection($user->FavServices);
        $data['providers'] = MiniProviderResource::collection($user->FavProviders);
        return response(['status' => 'true', 'message' => '', 'data' => $data], 200);
    }

    public function update(Request $request, $service_id = null)
    {
        if ($service_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.service_id_required'), 'data' => null], 422);
        if (!Service::find($service_id))
            return response()->json(['status' => 'false', 'message' => trans('app.service_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if (FavService::where(['user_id' => $request->user()->id, 'service_id' => $service_id])->first()) {
            $fav_service = FavService::where(['user_id' => $request->user()->id, 'service_id' => $service_id])->delete();
        } else {
            FavService::create(['user_id' => $request->user()->id, 'service_id' => $service_id]);
        }
        return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => null], 200);
    }

    public function update_provider_fav(Request $request, $provider_id = null)
    {
        if ($provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_id_required'), 'data' => null], 422);
        if (!User::where('type', 'provider')->find($provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($provider_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if (FavProvider::where(['user_id' => $request->user()->id, 'provider_id' => $provider_id])->first()) {
            $fav_provider = FavProvider::where(['user_id' => $request->user()->id, 'provider_id' => $provider_id])->delete();
        } else {
            FavProvider::create(['user_id' => $request->user()->id, 'provider_id' => $provider_id]);
        }
        return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => null], 200);
    }
}
