<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\StoreRequest;
use App\Http\Requests\Api\Cart\UpdateRequest;
use App\Http\Resources\Cart as CartResource;
use App\Models\AdditionCart;
use App\Models\Service;
use App\Models\Cart;
use App\User;
use Exception;
use DB;
use App\Http\Resources\MiniProviderResource;

class CartController extends MasterController
{
    public function show(Request $request)
    {
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        return response()->json(['status' => 'true', 'message' => isset($user->Cart[0])?'':trans('dash.empty_cart') , 'data' => CartResource::collection($user->Cart),
             'provider_data' => isset($user->Cart[0]) ? new MiniProviderResource($user->Cart[0]->Provider): null, 'delivery_price' => settings('delivery_price')] , 200);
    }

    public function store(StoreRequest $request)
    {
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $cart = Cart::where('user_id', $user->id)->first();
        $service = Service::find($request->service_id);
        if($service->Porivder->expire_date < date('Y-m-d H:i:s'))
            return response()->json(['status' => 'false', 'message' => trans('app.notSubscribed'), 'data' => null], 401);
        if($service->availability == 'unavailable')
            return response()->json(['status' => 'false', 'message' => trans('app.service_unavailable'), 'data' => null], 401);
        if ($cart != null && $cart->provider_id != $service->provider_id )
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_put_services_from_different_providers_or_categories'), 'data' => null], 401);
        if ($cart != null && $cart->is_deliverable !=$service->Category->is_deliverable )
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_put_services_with_different_delivery_type'), 'data' => null], 401);

        DB::beginTransaction();
        try {
            $new_cart = Cart::create($request->all() + [
                'user_id' => $request->user()->id,
                'provider_id' => $service->provider_id,
                'is_deliverable' => $service->Category->is_deliverable,
            ]);
            if ($request->additions) {
                foreach (json_decode($request->additions) as $addition) {
                    $new_addition = AdditionCart::create([
                        'cart_id' => $new_cart->id,
                        'addition_id' => $addition->id,
                        'count' => $addition->count,
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response()->json(['status' => 'true', 'message' => trans('app.added_successfully'), 'data' => null], 200);
    }

    public function update(UpdateRequest $request, $cart_id = null)
    {
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($cart_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.cart_id_required'), 'data' => null], 401);
        if (!Cart::find($cart_id))
            return response()->json(['status' => 'false', 'message' => trans('app.cart_not_found'), 'data' => null], 401);
        DB::beginTransaction();
        try {
            Cart::find($cart_id)->update(['count' => $request->count]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response()->json(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => CartResource::collection($user->Cart)], 200);
    }

    public function delete(Request $request, $cart_id = null)
    {
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($cart_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.cart_id_required'), 'data' => null], 401);
        if (!Cart::find($cart_id))
            return response()->json(['status' => 'false', 'message' => trans('app.cart_not_found'), 'data' => null], 401);
        try {
            Cart::find($request->cart_id)->delete();
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response()->json(['status' => 'true', 'message' => trans('app.deleted_successfully'), 'data' => CartResource::collection($user->Cart)], 200);
    }
}
