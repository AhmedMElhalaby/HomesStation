<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class MasterController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->header('lang')) {
            $this->lang = $request->header('lang') == 'en' ? 'en' : 'ar';
        } else {
            $setting_lang = \App\Models\Setting::where('key', 'app_lang')->first()->value;
            $this->lang = $setting_lang == "" ? 'ar' : $setting_lang;
        }
        if ($request->header('Authorization')) {
            $this->middleware('jwt.auth');
        }
        \Carbon\Carbon::setLocale("$this->lang");
        app()->setLocale($this->lang);
    }
}
