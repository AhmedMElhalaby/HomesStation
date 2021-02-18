<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function privacy()
    {
        return view('website.privacy');
    }

    public function contact()
    {
        return view('website.contact');
    }
    public function terms()
    {
        return view('website.terms');
    }
}
