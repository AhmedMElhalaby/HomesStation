<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends MasterController
{
    /**
     * Display a listing of the current orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function current_orders()
    {
        $this->data['orders'] = Order::whereNotIn(
            'order_status',
            [
                'products_provider_rejected',
                'services_provider_rejected',
                'products_finished_order_without_rate',
                'services_finished_order_without_rate',
                'products_finished_order_with_rate',
                'services_finished_order_with_rate'
            ]
        )->orderBy('created_at', 'DESC')
            ->get();
        return view('dashboard.order.index', $this->data);
    }

    /**
     * Display a listing of the finished orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function finished_orders()
    {
        $this->data['orders'] = Order::whereIn(
            'order_status',
            [
                'products_provider_rejected',
                'services_provider_rejected',
                'products_finished_order_without_rate',
                'services_finished_order_without_rate',
                'products_finished_order_with_rate',
                'services_finished_order_with_rate'
            ]
        )->orderBy('created_at', 'DESC')
            ->get();
        return view('dashboard.order.index', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Order::find($id)) {
            return back()->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['order'] = Order::find($id);
        return view('dashboard.order.show', $this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Order::find($id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $order = Order::find($id)->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')];
    }
}
