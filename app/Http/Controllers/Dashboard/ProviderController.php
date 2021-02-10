<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Country;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Device;
use DB;
use App\Http\Requests\Dashboard\Provider\ProviderStore;
use App\Http\Requests\Dashboard\Provider\ProviderUpdate;
use App\Models\Service;
use App\Models\Nationality;
use App\Http\Controllers\General\ImageController;
use App\Http\Controllers\General\NotificationController;

class ProviderController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $providers = User::where('type', 'provider')->latest();
        if($request->filled('active')){
            $providers = $providers->where('active',$request->active);
        }
        $providers = $providers->get();
        $this->data['providers'] = $providers;
        return view('dashboard.provider.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['countries'] = Country::all();
        $this->data['nationalities'] = Nationality::all();
        $this->data['categories'] = Category::all();
        $this->data['last_providers'] = User::orderBy('id', 'desc')->where('type', 'provider')->take(10)->get();
        return view('dashboard.provider.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderStore $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create($request->all() + ['role_id' => 1, 'type' => 'provider']);
            $provider_data = Provider::create([
                'user_id' => $user->id,
                'store_name' => $request->store_name,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'minimum_charge' => $request->minimum_charge,
                'commercial_register_number' => $request->commercial_register_number,
                'commercial_register_image' => $request->commercial_register_image,
            ]);
            $user->Categories()->attach($request->categories);
        });
        return redirect()->route('provider.index')->with('class', 'alert alert-success')->with('message', trans('dash.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!User::where('type', 'provider')->find($id)) {
            return redirect()->route('provider.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $data['provider'] = User::where('type', 'provider')->find($id);
        return view('dashboard.provider.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!User::where('type', 'provider')->find($id)) {
            return redirect()->route('provider.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['provider'] = User::where('type', 'provider')->find($id);
        $this->data['countries'] = Country::all();
        $this->data['nationalities'] = Nationality::all();
        $this->data['categories'] = Category::all();
        $this->data['last_providers'] = User::orderBy('id', 'desc')->where('type', 'provider')->take(10)->get();
        return view('dashboard.provider.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderUpdate $request, $id)
    {
        if (!User::where('type', 'provider')->find($id)) {
            return redirect()->route('provider.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        DB::beginTransaction();
        try {
            // dd($request->all());
            $user = User::where('type', 'provider')->find($id);
            $user->update($request->all());
            $provider_data = Provider::where('user_id', $user->id)->first()->update([
                'store_name' => $request->store_name,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'minimum_charge' => $request->minimum_charge,
                'commercial_register_number' => $request->commercial_register_number,
            ]);
            if($request->commercial_register_image){
                $provider_data = Provider::where('user_id', $user->id)->first()->update([
                    'commercial_register_image' => $request->commercial_register_image,
                ]);
            }
            $user->Categories()->sync($request->categories);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('provider.index')->with('class', 'alert alert-danger')->with('message', trans('auth.something_went_wrong_please_try_again'));
        }
        return redirect()->route('provider.index')->with('class', 'alert alert-success')->with('message', trans('dash.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!User::find($id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $user = User::find($id);
        if (isset($user->avatar) && $user->avatar != '') {
            if (file_exists(storage_path('app/uploads/users/avatar/org' . "/" . $user->avatar))) {
                ImageController::delete_image_from_folder($user->avatar, 'app/uploads/users/avatar');
            }
        }
        $user->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')];
    }

    /**
     * Display the provider's products resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_services($id)
    {
        if (!User::where('type', 'provider')->find($id)) {
            return redirect()->route('provider.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $data['provider'] = User::where('type', 'provider')->find($id);
        $data['services'] = Service::where('provider_id', $id)->get();
        return view('dashboard.provider.services', $data);
    }

    public function update_expire_date(Request $request)
    {
        if (!User::where('type', 'provider')->find($request->provider_id)) {
            return redirect()->route('provider.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $provider = User::where('type', 'provider')->find($request->provider_id);
        $provider->update(['expiration_notification'=>0,'expire_date' => date('Y-m-d H:i:s', strtotime($request->expire_date))]);

        $title_ar = 'قامت إدارة تطبيق هومز استشين بإرسال إشعار';
        $title_en = 'homes station management has sent notice to you';
        $title = app()->getLocale() == 'ar' ? $title_ar : $title_en;
        $body_ar = 'تم تجديد الاشتراك حتى ' . date('Y-m-d', strtotime($request->expire_date));
        $body_en = 'Subscription renewed up to ' . date('Y-m-d', strtotime($request->expire_date));
        $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

        $fcm_data = [];
        $fcm_data['title'] = $title;
        $fcm_data['key'] = 'management_message';
        $fcm_data['body'] = $body;
        $fcm_data['msg_sender'] = $request->user()->username;
        $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
        $fcm_data['time'] = date('Y-m-d H:i:s');

        add_notification($request->provider_id, 'management_message', 0, $body_ar, $body_en);

        if (Device::where('user_id', $request->provider_id)->exists()) {
            NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($request->provider_id, $title, $body, $fcm_data, (60 * 20));
        }

        return redirect()->route('provider.show', $request->provider_id)->with('class', 'alert alert-success')->with('message', trans('dash.updated_successfully'));
    }
}
