<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\User;

class HomeController extends MasterController
{
    public function index()
    {
        $this->data['categories_count'] = Category::count();
        $this->data['admins_count'] = User::where(['type' => 'admin'])->count();
        $this->data['users_count'] = User::where(['type' => 'user'])->count();
        $this->data['providers_count'] = User::where(['type' => 'provider'])->count();
        $this->data['delegates_count'] = User::where(['type' => 'delegate'])->count();
        $this->data['active_providers_count'] = User::where(['type' => 'provider'])->where('active','active')->count();
        $this->data['active_delegates_count'] = User::where(['type' => 'delegate'])->where('active','active')->count();
        $this->data['deactive_providers_count'] = User::where(['type' => 'provider'])->where('active','deactive')->count();
        $this->data['deactive_delegates_count'] = User::where(['type' => 'delegate'])->where('active','deactive')->count();
        $this->data['finished_orders_count'] = Order::whereIn(
            'order_status',
            [
                'products_provider_rejected',
                'services_provider_rejected',
                'products_finished_order_without_rate',
                'services_finished_order_without_rate',
                'products_finished_order_with_rate',
                'services_finished_order_with_rate'
            ]
        )->count();
        $this->data['current_orders_count'] = Order::whereNotIn(
            'order_status',
            [
                'products_provider_rejected',
                'services_provider_rejected',
                'products_finished_order_without_rate',
                'services_finished_order_without_rate',
                'products_finished_order_with_rate',
                'services_finished_order_with_rate'
            ]
        )->count();

        return view('dashboard.home.index', $this->data);
    }
}
