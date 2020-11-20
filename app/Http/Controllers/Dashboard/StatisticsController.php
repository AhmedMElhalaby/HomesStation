<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Order;

class StatisticsController extends MasterController
{
    public $now;

    public function __construct()
    {
        $this->now = Carbon::now();
    }

    function getWeekNo($date)
    {
        $t = strtotime($date);
        $w = (int)date('W', $t);
        $m = (int)date('n', $t);
        $w = ($w == 1 ? ($m == 12 ? 53 : 1) : ($w >= 51 ? ($m == 1 ? 0 : $w) : $w));

        return $w;
    }

    public function real_weekly()
    {
        $weekly_report = array();
        $weeks_counter_until_now_on_this_year = Carbon::createFromDate(date('Y'), date('m'), date('d'))->weekOfYear;
        for ($init = 0; $init < $weeks_counter_until_now_on_this_year; $init++) {
            $start_of_week = Carbon::create($this->now->format('Y'), 1, 01)->addWeeks($init)->format('Y-m-d');
            $end_of_week = Carbon::create($this->now->format('Y'), 1, 01)->addWeeks($init + 1)->format('Y-m-d');

            $orders = Order::whereIn('order_status', [
                'products_finished_order_without_rate',
                'products_finished_order_with_rate',
                'services_finished_order_without_rate',
                'services_finished_order_with_rate'
            ])->whereBetween('created_at', [$start_of_week, $end_of_week]);
            $delivery_price = $orders->get()->sum('delivery_price');
            $total_order_price = $orders->get()->sum('total_order_price');
            $app_price_from_provider = $orders->get()->sum('app_price_from_provider');
            $week_dates_sum = array(
                'week_number' => $init + 1,
                'start_day_of_week' => $start_of_week,
                'end_day_of_week' => $end_of_week,
                'delivery_price' => $delivery_price,
                'total_order_price' => $total_order_price,
                'app_precentage_from_provider' => $app_price_from_provider,
            );
            array_push($weekly_report, $week_dates_sum);
        }
        $this->data['weekly_report'] = $weekly_report;
        return view('dashboard.statiststics.real_weekly', $this->data);
    }

    public function real_yearly(Request $request)
    {
        $year = date('Y');
        $this_month = date('m');
        if ($request->other_year) {
            $year = $request->other_year;
            $this_month = 12;
        }
        $totaly_delivery_price = 0;
        $totaly_total_order_price = 0;
        $totaly_app_price_from_provider = 0;
        $yearly_report = array();
        for ($init = 1; $init <= $this_month; $init++) {
            $orders = Order::whereIn('order_status', [
                'products_finished_order_without_rate',
                'products_finished_order_with_rate',
                'services_finished_order_without_rate',
                'services_finished_order_with_rate'
            ])->whereRaw('MONTH(created_at) = ?', [$init])->whereRaw('YEAR(created_at) = ?', [$year]);
            $delivery_price = $orders->get()->sum('delivery_price');
            $total_order_price = $orders->get()->sum('total_order_price');
            $app_price_from_provider = $orders->get()->sum('app_price_from_provider');;
            $totaly_delivery_price = $totaly_delivery_price + $delivery_price;
            $totaly_total_order_price = $totaly_total_order_price + $total_order_price;
            $totaly_app_price_from_provider = $totaly_app_price_from_provider + $app_price_from_provider;
            $this_month_statics = array(
                'month_number' => $init . "-" . $year,
                'delivery_price' => $delivery_price,
                'total_order_price' => $total_order_price,
                'app_price_from_provider' => $app_price_from_provider,
            );
            array_push($yearly_report, $this_month_statics);
        }
        $this->data['current_year'] = $year;
        $this->data['totaly_delivery_price'] = $totaly_delivery_price;
        $this->data['totaly_total_order_price'] = $totaly_total_order_price;
        $this->data['totaly_app_price_from_provider'] = $totaly_app_price_from_provider;
        $this->data['yearly_report'] = $yearly_report;
        return view('dashboard.statiststics.real_yearly', $this->data);
    }

    public function real_weekly_days(Request $request)
    {
        if ($request->from && $request->to) {
            $from_year = date("Y", strtotime($request->from));
            $from_month = date("m", strtotime($request->from));
            $from_day = date("d", strtotime($request->from));

            $to_year = date("Y", strtotime($request->to));
            $to_month = date("m", strtotime($request->to));
            $to_day = date("d", strtotime($request->to));

            $from = Carbon::createFromDate($from_year, $from_month, $from_day);
            $to = Carbon::createFromDate($to_year, $to_month, $to_day);
            $dates = $this->generateDateRange($from, $to);
            $this->data['days'] = $dates;
            return view('dashboard.statiststics.days_report_real', $this->data);
        }
    }

    public function real_yearly_days(Request $request)
    {
        if ($request->month) {
            $month = date("m", strtotime("1-" . $request->month));
            $year = date("Y", strtotime("1-" . $request->month));
            $first_day = 1;
            $first_date_in_month = $year . "-" . $month . "-" . $first_day;
            $last_day = date('t', strtotime($first_date_in_month));
            $last_date_in_month = $year . "-" . $month . "-" . $last_day;

            $from = Carbon::createFromDate($year, $month, $first_day);
            $to = Carbon::createFromDate($year, $month, $last_day);
            $dates = $this->generateDateRange($from, $to);
            $this->data['days'] = $dates;
            return view('dashboard.statiststics.days_report_real', $this->data);
        }
    }

    private function generateDateRange(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];
        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }
        return $dates;
    }
}
