<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationList;
use App\Models\Notification;

class NotificationController extends MasterController
{
    public function show(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user()->id)->orderBy('created_at', 'DESC')->get();
        Notification::where('user_id', $request->user()->id)->update(['is_seen' => 'seen']);
        return response(['status' => 'true', 'message' => '', 'data' => NotificationList::collection($notifications)], 200);
    }

    /** 
     * Delete Product data api
     * 
     * @return \Illuminate\Http\Response 
     */
    public function delete(Request $request, $notification_id = null)
    {
        if ($notification_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.notification_id_required'), 'data' => null], 422);
        if (!Notification::find($notification_id))
            return response()->json(['status' => 'false', 'message' => trans('app.notification_not_found'), 'data' => null], 404);
        if (Notification::find($notification_id)->user_id != $request->user()->id)
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_delete'), 'data' => null], 404);
        Notification::find($notification_id)->delete();
        return response(['status' => 'true', 'message' => trans('app.deleted_successfully'), 'data' => null], 200);
    }
}
