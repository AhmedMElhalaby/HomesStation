<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends MasterController
{
    public function about()
    {
        return response()->json(['status' => 'true', 'message' => '', 'data' => ['about' => settings('about_' . app()->getLocale())]], 200);
    }

    public function terms()
    {
        return response()->json(['status' => 'true', 'message' => '', 'data' => ['policy_terms' => settings('policy_terms_' . app()->getLocale())]], 200);
    }

    public function social_info()
    {
        $settings = [
            'email' => settings('email'),
            'mobile' => settings('mobile'),
            'facebook_url' => settings('facebook_url'),
            'twitter_url' => settings('twitter_url'),
            'youtube_url' => settings('youtube_url'),
            'instagram_url' => settings('instagram_url'),
            'whatsapp_phone' => settings('whatsapp_phone'),
            'price_of_delegate_subscription' => (integer) settings('price_of_delegate_subscription'),
            'price_of_publishing_an_ad' => (integer) settings('price_of_publishing_an_ad'),
        ];
        return response()->json(['status' => 'true', 'message' => '', 'data' => $settings], 200);
    }
}
