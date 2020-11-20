<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.setting.index');
    }

    public function update(Request $request)
    {
        if ($request->app_lang)
            Setting::where('key', 'app_lang')->update(['value' => $request->app_lang]);
        if ($request->mobile)
            Setting::where('key', 'mobile')->update(['value' => $request->mobile]);
        if ($request->email)
            Setting::where('key', 'email')->update(['value' => $request->email]);
        if ($request->facebook_url)
            Setting::where('key', 'facebook_url')->update(['value' => $request->facebook_url]);
        if ($request->youtube_url)
            Setting::where('key', 'youtube_url')->update(['value' => $request->youtube_url]);
        if ($request->instagram_url)
            Setting::where('key', 'instagram_url')->update(['value' => $request->instagram_url]);
        if ($request->twitter_url)
            Setting::where('key', 'twitter_url')->update(['value' => $request->twitter_url]);
        if ($request->whatsapp_phone)
            Setting::where('key', 'whatsapp_phone')->update(['value' => $request->whatsapp_phone]);
        if ($request->about_ar)
            Setting::where('key', 'about_ar')->update(['value' => $request->about_ar]);
        if ($request->about_en)
            Setting::where('key', 'about_en')->update(['value' => $request->about_en]);
        if ($request->policy_terms_ar)
            Setting::where('key', 'policy_terms_ar')->update(['value' => $request->policy_terms_ar]);
        if ($request->policy_terms_en)
            Setting::where('key', 'policy_terms_en')->update(['value' => $request->policy_terms_en]);
        if ($request->num_of_search_km_for_provider)
            Setting::where('key', 'num_of_search_km_for_provider')->update(['value' => $request->num_of_search_km_for_provider]);
        // if ($request->app_precentage_from_provider)
        //     Setting::where('key', 'app_precentage_from_provider')->update(['value' => $request->app_precentage_from_provider]);
        if ($request->price_of_publishing_an_ad)
            Setting::where('key', 'price_of_publishing_an_ad')->update(['value' => $request->price_of_publishing_an_ad]);
        if ($request->free_trial_availability)
            Setting::where('key', 'free_trial_availability')->update(['value' => $request->free_trial_availability]);
        if ($request->free_trial_period_type)
            Setting::where('key', 'free_trial_period_type')->update(['value' => $request->free_trial_period_type]);
        if ($request->free_trial_period)
            Setting::where('key', 'free_trial_period')->update(['value' => $request->free_trial_period]);
        return redirect()->route('setting.index')->with('class', 'alert alert-success')->with('message', trans('dash.updated_successfully'));;
    }
}
