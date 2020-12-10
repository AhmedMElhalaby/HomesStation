<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryAuth;
use App\Models\Category;
use App\Http\Resources\MiniProviderResource;
use App\User;
use App\Models\Service;
use App\Http\Resources\MiniServiceResource;

class CategoryController extends MasterController
{
    public function index()
    {
        if(auth('api')->check()){
            return response(['status' => 'true', 'message' => '', 'data' => CategoryAuth::collection(Category::all())], 200);
        }
        return response(['status' => 'true', 'message' => '', 'data' => CategoryResource::collection(Category::all())], 200);
    }

    public function get_providers($category_id = null)
    {
        if ($category_id == null) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_id_required'), 'data' => null], 422);
        }
        if (!Category::find($category_id)) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_not_found'), 'data' => null], 404);
        }
        $providers = User::active()->subscribed()->whereHas('Categories', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->get();
        return response(['status' => 'true', 'message' => '', 'data' => MiniProviderResource::collection($providers)], 200);
    }

    public function get_services_by_category(Request $request, $category_id = null)
    {
        if ($category_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.category_id_required'), 'data' => null], 422);
        if (!Category::find($category_id))
            return response()->json(['status' => 'false', 'message' => trans('app.category_not_found'), 'data' => null], 404);
        $services = Service::where(['category_id' => $category_id])->where('is_hidden',false);
        if ($request->subcategory_id) {
            $services->where(['subcategory_id' => $request->subcategory_id]);
        }
        return response(['status' => 'true', 'message' => '', 'data' => MiniServiceResource::collection($services->get())], 200);

    }

}
