<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Country;
use App\Models\Device;
use App\Http\Requests\Dashboard\Delegate\DelegateStore;
use App\Models\Nationality;
use App\Http\Requests\Dashboard\Delegate\DelegateUpdate;
use App\Http\Controllers\General\ImageController;
use App\Http\Controllers\General\NotificationController;

class DelegateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $delegates = User::where('type', 'delegate')->latest();
        if($request->filled('active')){
            $delegates = $delegates->where('active',$request->active);
        }
        $delegates = $delegates->get();
        $this->data['delegates'] = $delegates;
        return view('dashboard.delegate.index', $this->data);
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
        $this->data['last_delegates'] = User::orderBy('id', 'desc')->where('type', 'delegate')->take(10)->get();
        return view('dashboard.delegate.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DelegateStore $request)
    {
        $user = User::create($request->validated() + ['role_id' => 1, 'type' => 'delegate']);
        return redirect()->route('delegate.index')->with('class', 'alert alert-success')->with('message', trans('dash.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!User::where('type', 'delegate')->find($id)) {
            return redirect()->route('delegate.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['delegate'] = User::where('type', 'delegate')->find($id);
        return view('dashboard.delegate.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!User::where('type', 'delegate')->find($id)) {
            return redirect()->route('delegate.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['nationalities'] = Nationality::all();
        $this->data['delegate'] = User::where('type', 'delegate')->find($id);
        $this->data['countries'] = Country::all();
        $this->data['last_delegates'] = User::orderBy('id', 'desc')->where('type', 'delegate')->take(10)->get();
        return view('dashboard.delegate.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DelegateUpdate $request, $id)
    {
        if (!User::where('type', 'delegate')->find($id)) {
            return redirect()->route('delegate.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $delegate = User::find($id)->update($request->all());
        return redirect()->route('delegate.index')->with('class', 'alert alert-success')->with('message', trans('dash.updated_successfully'));
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
        $delegate = User::find($id);
        if (isset($delegate->avatar) && $delegate->avatar != '') {
            if (file_exists(storage_path('app/uploads/users/avatar/org' . "/" . $delegate->avatar))) {
                ImageController::delete_image_from_folder($delegate->avatar, 'app/uploads/users/avatar');
            }
        }
        $delegate->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')];
    }

    public function update_expire_date(Request $request)
    {
        if (!User::where('type', 'delegate')->find($request->delegate_id)) {
            return redirect()->route('delegate.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $delegate = User::where('type', 'delegate')->find($request->delegate_id);
        $delegate->update(['expire_date' => date('Y-m-d H:i:s', strtotime($request->expire_date))]);

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

        add_notification($request->delegate_id, 'management_message', 0, $body_ar, $body_en);

        if (Device::where('user_id', $request->delegate_id)->exists()) {
            NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($request->delegate_id, $title, $body, $fcm_data, (60 * 20));
        }

        return redirect()->route('delegate.show', $request->delegate_id)->with('class', 'alert alert-success')->with('message', trans('dash.updated_successfully'));
    }
}
