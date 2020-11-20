<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Country;
use App\Http\Requests\Dashboard\User\UserStore;
use App\Http\Requests\Dashboard\User\UserUpdate;
use App\Http\Controllers\General\ImageController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['users'] = User::where('type', 'user')->latest()->get();
        return view('dashboard.user.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['countries'] = Country::all();
        $this->data['last_users'] = User::orderBy('id', 'desc')->where('type', 'user')->take(10)->get();
        return view('dashboard.user.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStore $request)
    {
        $user = User::create($request->all() + ['role_id' => 1, 'type' => 'user']);
        return redirect()->route('user.index')->with('class', 'alert alert-success')->with('message', trans('dash.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!User::where('type', 'user')->find($id)) {
            return redirect()->route('user.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['user'] = User::where('type', 'user')->find($id);
        return view('dashboard.user.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!User::where('type', 'user')->find($id)) {
            return redirect()->route('user.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['user'] = User::where('type', 'user')->find($id);
        $this->data['countries'] = Country::all();
        $this->data['last_users'] = User::orderBy('id', 'desc')->where('type', 'user')->take(10)->get();
        return view('dashboard.user.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, $id)
    {
        if (!User::where('type', 'user')->find($id)) {
            return redirect()->route('user.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $user = User::find($id)->update($request->all());
        return redirect()->route('user.index')->with('class', 'alert alert-success')->with('message', trans('dash.updated_successfully'));
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
}
