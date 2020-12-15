<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use App\Http\Requests\Api\Service\StoreRequest;
use App\Http\Requests\Api\Service\UpdateRequest;
use App\Models\Service;
use App\Models\ImageService;
use App\Models\AdditionService;
use App\Http\Controllers\General\ImageController;
use App\User;
use App\Http\Resources\Service as ServiceResource;
use App\Models\Subcategory;
use App\Models\CategoryProvider;
use App\Http\Resources\MiniServiceResource;
use App\Models\Category;
use App\Models\ServiceRate;
use App\Models\UserReport;

class ServiceController extends MasterController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        if ($request->header('Authorization')) {
            $this->middleware('jwt.auth');
        }
    }

    /**
     * Store New Product api
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $subcategory = Subcategory::find($request->subcategory_id);
            $category_provider = CategoryProvider::where(['user_id' => $request->user()->id, 'category_id' => $subcategory->category_id])->first();
            $service = Service::create($request->validated() + [
                'provider_id' => $request->user()->id,
                'category_id' => $subcategory->category_id,
                'category_provider_id' => $category_provider->id
            ]);
            if ($request->additions) {
                $additions = json_decode($request->additions);
                foreach ($additions as $addition) {
                    $service_addition = $service->Additions()->create((array)$addition);
                }
            }
            foreach ($request->file('images') as $image) {
                $service_image = ImageService::create(['service_id' => $service->id, 'image' => $image]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => $e->getMessage()], 401);
        }
        return response()->json(['status' => 'true', 'message' => trans('app.added_successfully'), 'data' => new ServiceResource(Service::find($service->id))], 200);
    }

    /**
     * Show Product data api
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $service_id = null)
    {
        if ($service_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.service_id_required'), 'data' => null], 422);
        if (!Service::find($service_id))
            return response()->json(['status' => 'false', 'message' => trans('app.service_not_found'), 'data' => null], 404);
        $service = Service::find($service_id);
        $service->update(['views_count' => ($service->views_count + 1)]);
        return response(['status' => 'true', 'message' => '', 'data' => new ServiceResource($service)], 200);
    }

    /**
     * Update Product data api
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $service_id = null)
    {
        if ($service_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.service_id_required'), 'data' => null], 422);
        if (!Service::find($service_id))
            return response()->json(['status' => 'false', 'message' => trans('app.service_not_found'), 'data' => null], 404);
        if (Service::find($service_id)->CategoryProvider->user_id != $request->user()->id)
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_modify'), 'data' => null], 404);
        DB::beginTransaction();
        try {
            $subcategory = Subcategory::find($request->subcategory_id);
            $category_provider = CategoryProvider::where(['user_id' => $request->user()->id, 'category_id' => $subcategory->category_id])->first();
            $service = Service::find($service_id);
            $service->update($request->validated() + [
                'category_id' => $subcategory->category_id,
                'category_provider_id' => $category_provider->id
            ]);
            if ($request->additions) {
                $additions = json_decode($request->additions);
                foreach ($additions as $addition) {
                    if ($addition->id != 0) {
                        $service_addition = $service->Additions()->find($addition->id)->update((array)$addition);
                    } else {
                        $service_addition = $service->Additions()->create((array)$addition);
                    }
                }
            }
            if ($request->images) {
                foreach ($request->images as $image) {
                    $service_image = ImageService::create(['service_id' => $service->id, 'image' => $image]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response(['status' => 'true', 'message' => '', 'data' => new ServiceResource(Service::find($service_id))], 200);
    }

    /**
     * Delete Product data api
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $service_id = null)
    {
        if ($service_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.service_id_required'), 'data' => null], 422);
        if (!Service::find($service_id))
            return response()->json(['status' => 'false', 'message' => trans('app.service_not_found'), 'data' => null], 404);
        if (Service::find($service_id)->provider_id != $request->user()->id)
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_delete'), 'data' => null], 404);
        Service::find($service_id)->delete();
        return response(['status' => 'true', 'message' => trans('app.deleted_successfully'), 'data' => null], 200);
    }

    /**
     * Delete Image api
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_image(Request $request, $image_id = null)
    {
        if ($image_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.image_id_required'), 'data' => null], 422);
        if (!ImageService::find($image_id))
            return response()->json(['status' => 'false', 'message' => trans('app.image_not_found'), 'data' => null], 404);
        if (ImageService::find($image_id)->Service->provider_id != $request->user()->id)
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_delete'), 'data' => null], 404);
        $image = ImageService::find($image_id)->delete();
        return response(['status' => 'true', 'message' => trans('app.deleted_successfully'), 'data' => null], 200);
    }

    /**
     * Delete Addition api
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_addition(Request $request, $addition_id = null)
    {
        if ($addition_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.addition_id_required'), 'data' => null], 422);
        if (!AdditionService::find($addition_id))
            return response()->json(['status' => 'false', 'message' => trans('app.addition_not_found'), 'data' => null], 404);
        if (AdditionService::find($addition_id)->Service->provider_id != $request->user()->id)
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_delete'), 'data' => null], 404);
        AdditionService::find($addition_id)->delete();
        return response(['status' => 'true', 'message' => trans('app.deleted_successfully'), 'data' => null], 200);
    }

    /**
     * Get Services By Category Provider api
     *
     * @return \Illuminate\Http\Response
     */
    public function services_by_category_provider(Request $request, $category_provider_id = null)
    {
        if ($category_provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.category_provider_id_required'), 'data' => null], 422);
        if (!CategoryProvider::find($category_provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.category_provider_not_found'), 'data' => null], 404);
        $category_provider_data = CategoryProvider::find($category_provider_id);
        $provider = User::where('type', 'provider')->find($category_provider_data->user_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($request->subcategory_id) {
            $services = Service::where(['category_provider_id' => $category_provider_id, 'subcategory_id' => $request->subcategory_id, 'is_hidden' => false])->get();
        } else {
            $services = Service::where('category_provider_id', $category_provider_id)->where('is_hidden', false)->get();
        }
        return response(['status' => 'true', 'message' => '', 'data' => MiniServiceResource::collection($services)], 200);

    }

    /**
     * Get Services By Category Provider api
     *
     * @return \Illuminate\Http\Response
     */
    public function services_by_category_id_provider_id(Request $request, $provider_id = null, $category_id = null)
    {
        if ($category_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.category_id_required'), 'data' => null], 422);
        if (!Category::find($category_id))
            return response()->json(['status' => 'false', 'message' => trans('app.category_not_found'), 'data' => null], 404);
        if ($provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_id_required'), 'data' => null], 422);
        if (!User::where('type', 'provider')->find($provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($provider_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $category_provider_data = CategoryProvider::where(['user_id' => $provider_id, 'category_id' => $category_id])->first();
        if ($request->subcategory_id) {
            $services = Service::where(['category_provider_id' => $category_provider_data->id, 'subcategory_id' => $request->subcategory_id, 'is_hidden' => false])->get();
        } else {
            $services = Service::where('category_provider_id', $category_provider_data->id)->where('is_hidden', false)->get();
        }
        return response(['status' => 'true', 'message' => '', 'data' => MiniServiceResource::collection($services)], 200);

    }

    public function rate_service(Request $request, $service_id = null)
    {
        if ($service_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.service_id_required'), 'data' => null], 422);
        if ($request->rate == null)
            return response()->json(['status' => 'false', 'message' => trans('app.rate_required'), 'data' => null], 401);
        if (!Service::find($service_id))
            return response()->json(['status' => 'false', 'message' => trans('app.service_not_found'), 'data' => null], 404);
        if (ServiceRate::where(['user_id' => $request->user()->id, 'service_id' => $service_id])->first()) {
            ServiceRate::where(['user_id' => $request->user()->id, 'service_id' => $service_id])->update(['rate' => $request->rate]);
        } else {
            ServiceRate::create(['user_id' => $request->user()->id, 'service_id' => $service_id, 'rate' => $request->rate]);
        }
        return response(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => null], 200);
    }

    public function send_report(Request $request, $service_id = null)
    {
        if ($service_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.service_id_required'), 'data' => null], 422);
        if ($request->reason == null)
            return response()->json(['status' => 'false', 'message' => trans('app.reason_required'), 'data' => null], 401);
        if (!Service::find($service_id))
            return response()->json(['status' => 'false', 'message' => trans('app.service_not_found'), 'data' => null], 404);
        $report = UserReport::create([
            'user_id' => $request->user()->id,
            'key' => 'service',
            'key_id' => $service_id,
            'reason' => $request->reason,
        ]);
        return response(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => null], 200);
    }
    public function update_availability(Request $request, $id)
    {
        if ($id == null) {
            return response()->json(['status' => 'false', 'message' => trans('id is required'), 'data' => null], 422);
        }
        $Service = Service::find($id);
        if (!$Service) {
            return response()->json(['status' => 'false', 'message' => trans('Service is not found'), 'data' => null], 404);
        }
        if ($Service->is_hidden) {
            $Service->is_hidden = false;
        }else{
            $Service->is_hidden = true;
        }
        $Service->save();
        return response()->json(['status' => 'true', 'message' => '', 'data' => new \App\Http\Resources\Service($Service)], 200);
    }
}
