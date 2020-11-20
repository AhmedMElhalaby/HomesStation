<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use App\Models\Role;
use App\Http\Requests\Dashboard\Auth\UpdateData;
use App\Http\Requests\Dashboard\Auth\UpdatePassword;

class AuthController extends Controller
{
    public function signin_view()
    {
        return view('dashboard.auth.login');
    }

    public function signin(Request $request)
    {        
        if ($request->email && $request->password) {
            if (auth()->attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'admin'], true)) {
                return redirect()->route('dashboard.home');
            } else {
                $request->session()->flash('warning', trans('dashboard.email_or_password_invalid'));
                return redirect()->route('dashboard.login');
            }
        } else {
            $request->session()->flash('warning', trans('dashboard.compelete_info'));
            return redirect()->route('dashboard.login');
        }
    }

    public function signout()
    {
        auth()->logout();
        return redirect()->route('dashboard.login')
            ->with('message', trans('dash.logged_out_successfully'))
            ->with('class', 'alert alert-success');
    }

    public function profile()
    {
        $this->data['countries'] = \App\Models\Country::get();
        $this->data['roles'] = Role::where('id', '>', 1)->get();
        return view('dashboard.auth.profile', $this->data);
    }

    public function update(UpdateData $request)
    {
        User::find(auth()->id())->update($request->validated());
        return redirect()->route('admin.profile')->with('class', 'alert alert-success')->with('message', trans('dash.updated_successfully'));
    }

    public function update_password(UpdatePassword $request)
    {        
        if (Hash::check($request->old_password, auth()->user()->getAuthPassword())) {
            User::find(auth()->id())->update($request->all());
            return redirect()->route('admin.profile')->with('class', 'alert alert-success')->with('message', trans('dash.updated_password_successfully'));
        } else {
            return back()->with('message', trans('dash.wrong_password'))->with('class', 'alert alert-danger');
        }
    }
}
