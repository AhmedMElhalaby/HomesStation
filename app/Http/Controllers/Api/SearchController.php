<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MiniProviderResource;
use App\User;
use App\Models\Service;
use App\Http\Resources\MiniServiceResource;

class SearchController extends MasterController
{
    public function nearest_providers(Request $request)
    {
        if (!$request->lat || !$request->lng)
            return response()->json(['status' => 'false', 'message' => trans('app.lat_and_lng_required'), 'data' => null], 422);
        return response([
            'status' => 'true',
            'message' => '',
            'data' => MiniProviderResource::collection(User::whereHas('ProviderData', function ($q) {
                $q->available();
            })->where('type', 'provider')->active()->subscribed()->nearest($request->lat, $request->lng, settings('num_of_search_km_for_provider'))->get())
        ], 200);
    }

    public function provider_show($id){
        $provider = User::find($id);
        if ($provider) {
            return response([
                'status' => 'true',
                'message' => '',
                'data' => new MiniProviderResource($provider)
            ], 200);
        }else{
            return response()->json(['status' => 'false', 'message' => trans('app.object_not_found'), 'data' => null], 422);
        }
    }

    public function provider_search(Request $request)
    {
        if (!$request->provider_name)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_name_required'), 'data' => null], 422);
        $users = User::whereHas('ProviderData', function ($q) {
            $q->available();
        })->where('type', 'provider')->where('username', 'LIKE', '%' . $request->provider_name . '%')->active()->subscribed()->get();
        return response([
            'status' => 'true',
            'message' => '',
            'data' => MiniProviderResource::collection($users)
        ], 200);
    }

    public function search_product(Request $request)
    {
        if (!$request->subcategory_id || !$request->subcategory_tag_id)
            return response()->json(['status' => 'false', 'message' => trans('app.sub_cat_id_and_txt_required'), 'data' => null], 422);
        $services = Service::where(['subcategory_id' => $request->subcategory_id, 'subcategory_tag_id' => $request->subcategory_tag_id])->get();
        return response(['status' => 'true', 'message' => '', 'data' => MiniServiceResource::collection($services)], 200);
    }

    public function search_provider(Request $request)
    {
        if (!$request->subcategory_id && !$request->subcategory_tag_id)
            return response()->json(['status' => 'false', 'message' => trans('app.sub_cat_id_and_txt_required'), 'data' => null], 422);
        $providers = User::where('type', 'provider')->active()->subscribed()->whereHas('ProviderData', function ($q) {
            $q->available();
        });

        if($request->filled('subcategory_id') && ! $request->filled('subcategory_tag_id')){
            $providers = $providers->whereHas('Services', function ($query) use ($request) {
                $query->where(['subcategory_id' => $request->subcategory_id]);
            })->get();
        }
        if(! $request->filled('subcategory_id') && $request->filled('subcategory_tag_id')){
            $providers = $providers->whereHas('Services', function ($query) use ($request) {
                $query->where(['subcategory_tag_id' => $request->subcategory_tag_id]);
            })->get();
        }
        if($request->filled('subcategory_id') && $request->filled('subcategory_tag_id')){
            $providers = $providers->whereHas('Services', function ($query) use ($request) {
                $query->where(['subcategory_id' => $request->subcategory_id, 'subcategory_tag_id' => $request->subcategory_tag_id]);
            })->get();
        }
        return response(['status' => 'true', 'message' => '', 'data' => MiniProviderResource::collection($providers)], 200);
    }

    public function search_provider_by_subcategory_id(Request $request)
    {
        if (!$request->subcategory_id)
            return response()->json(['status' => 'false', 'message' => trans('app.subcategory_id_required'), 'data' => null], 422);
        $providers = User::where('type', 'provider')->active()->subscribed()->whereHas('ProviderData', function ($q) {
            $q->available();
        })->whereHas('Services', function ($query) use ($request) {
            $query->where(['subcategory_id' => $request->subcategory_id]);
        })->get();
        return response(['status' => 'true', 'message' => '', 'data' => MiniProviderResource::collection($providers)], 200);
    }
}
