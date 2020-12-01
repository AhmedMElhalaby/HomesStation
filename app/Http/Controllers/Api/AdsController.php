<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Ads\StoreAds;
use App\Models\BookingAds;
use App\User;
use App\Http\Resources\Ads;
use App\Models\Category;

class AdsController extends MasterController
{
    public function send(StoreAds $request)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if (BookingAds::where(['category_id' => $request->category_id, 'city_id' => $request->city_id])->whereDate('date_day', '=', $request->date_day)->count() >= (integer)settings('number_of_ads'))
            return response()->json(['status' => 'false', 'message' => trans('app.reached_to_the_maximum_number_of_ads_in_this_day'), 'data' => null], 401);
        $booking_ads = BookingAds::create($request->validated() + ['user_id' => $request->user()->id]);
        return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => new Ads($booking_ads)], 200);
    }

    public function days(Request $request)
    {
        $city_id = $request->city_id ?? ($request->user() ? $request->user()->city_id : 1);
        $data = [];
        for ($i = 1; $i <= 7; $i++) {
            $carbon = \Carbon\Carbon::now()->addDays($i);
            $day_data = [];
            $day_data['day_name'] = $carbon->format('l');
            $day_data['date'] = $carbon->toDateString();
            $ads_count = BookingAds::where(['city_id' => $city_id, 'category_id' => $request->category_id])->whereDate('date_day', $carbon->toDateString())->accepted()->count();
            $day_data['ads_count'] = $ads_count;
            $day_data['availability'] = $ads_count >= 10 ? 'unavailable' : 'available';
            $data[] = $day_data;
        }
        return response()->json(['status' => 'true', 'message' => '', 'data' => $data], 200);
    }

    public function ads_today(Request $request, $category_id = null)
    {
        if ($category_id == null) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_id_required'), 'data' => null], 422);
        }
        if (!Category::find($category_id)) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_not_found'), 'data' => null], 404);
        }
        $ads = BookingAds::where(['category_id' => $category_id, 'city_id' => $request->city_id])->accepted()->today()->get();
        return response()->json(['status' => 'true', 'message' => '', 'data' => Ads::collection($ads)], 200);
    }
}
