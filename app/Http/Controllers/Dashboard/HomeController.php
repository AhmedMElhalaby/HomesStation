<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\User;

class HomeController extends MasterController
{
    public function index()
    {
        $this->data['categories_count'] = Category::count();
        $this->data['admins_count'] = User::where(['type' => 'admin'])->count();
        $this->data['users_count'] = User::where(['type' => 'user'])->count();
        $this->data['providers_count'] = User::where(['type' => 'provider'])->count();
        return view('dashboard.home.index', $this->data);
    }
}
