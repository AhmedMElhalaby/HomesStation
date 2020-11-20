<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Subcategory as SubcategoryResource;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\SubcategoryTag;
use App\Http\Resources\SubcategoryTag as SubcategoryTagResource;

class SubcategoryController extends MasterController
{
    public function index($category_id = null)
    {
        if ($category_id == null) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_id_required'), 'data' => null], 422);
        }
        if (!Category::find($category_id)) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_not_found'), 'data' => null], 404);
        }
        return response(['status' => 'true', 'message' => '', 'data' => SubcategoryResource::collection(Subcategory::where('category_id', $category_id)->get())], 200);
    }

    public function tags($subcategory_id = null)
    {
        if ($subcategory_id == null) {
            return response()->json(['status' => 'false', 'message' => trans('app.subcategory_id_required'), 'data' => null], 422);
        }
        if (!Subcategory::find($subcategory_id)) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_not_found'), 'data' => null], 404);
        }
        return response(['status' => 'true', 'message' => '', 'data' => SubcategoryTagResource::collection(SubcategoryTag::where('subcategory_id', $subcategory_id)->get())], 200);
    }
}
