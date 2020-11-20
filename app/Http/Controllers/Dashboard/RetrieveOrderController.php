<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class RetrieveOrderController extends Controller
{
    /**
     * Display a listing of the requests retrieve orders .
     *
     * @return \Illuminate\Http\Response
     */
    public function all_requests()
    {
        $this->data['orders'] = Order::where('retrieve_step', 'waiting')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('dashboard.retrieve_order.requests', $this->data);
    }

    /**
     * Display a listing of the retrieved orders .
     *
     * @return \Illuminate\Http\Response
     */
    public function all_retrieved()
    {
        $this->data['orders'] = Order::where('retrieve_step', 'accept')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('dashboard.retrieve_order.retrieved', $this->data);
    }

    public function reply_request(Request $request)
    {
        if (!Order::find($request->order_id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        if ($request->reply == 'accept') {
            Order::find($request->order_id)->update(['retrieve_step' => 'accept']);
        } else {
            Order::find($request->order_id)->update(['retrieve_step' => 'reject']);
        }
        return ['status' => 'true', 'message' => trans('dash.updated_successfully')];
    }

}
