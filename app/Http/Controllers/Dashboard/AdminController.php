<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Country;
use App\Http\Requests\Dashboard\Admin\AdminStore;
use App\Models\Role;
use App\Http\Requests\Dashboard\Admin\AdminUpdate;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['admins'] = User::where('type', 'admin')->get();
        return view('dashboard.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['countries'] = Country::all();
        $this->data['roles'] = Role::where('id', '>', 1)->get();
        $this->data['last_admins'] = User::orderBy('id', 'desc')->where('type', 'admin')->take(10)->get();
        return view('dashboard.admin.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStore $request)
    {
        $user = User::create($request->all() + ['type' => 'admin']);
        return redirect()->route('admin.index')->with('class', 'alert alert-success')->with('message', trans('dash.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!User::where('type', 'admin')->find($id)) {
            return redirect()->route('admin.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['admin'] = User::where('type', 'admin')->find($id);
        $this->data['countries'] = Country::all();
        $this->data['roles'] = Role::where('id', '>', 1)->get();
        $this->data['last_admins'] = User::orderBy('id', 'desc')->where('type', 'admin')->take(10)->get();
        return view('dashboard.admin.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdate $request, $id)
    {
        if (!User::where('type', 'admin')->find($id)) {
            return redirect()->route('admin.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $admin = User::find($id)->update($request->all());
        return redirect()->route('admin.index')->with('class', 'alert alert-success')->with('message', trans('dash.updated_successfully'));
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
        $admin = User::find($id);
        if (isset($admin->avatar) && $admin->avatar != '') {
            if (file_exists(storage_path('app/uploads/users/avatar/org' . "/" . $admin->avatar))) {
                ImageController::delete_image_from_folder($admin->avatar, 'app/uploads/users/avatar');
            }
        }
        $admin->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')];
    }
}
