<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserReport;

class UserReportController extends Controller
{
    public function index()
    {
        $data['user_reports_for_providers'] = UserReport::where('key', 'provider')->get();
        $data['user_reports_for_services'] = UserReport::where('key', 'service')->get();
        $data['user_reports_for_orders'] = UserReport::where('key', 'order')->get();
        return view('dashboard.user_reports.index', $data);
    }

    public function show($id)
    {
        if (!UserReport::find($id)) {
            return back()->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['user_report'] = UserReport::find($id);
        return view('dashboard.user_reports.show', $this->data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!UserReport::find($id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $user_report = UserReport::find($id);
        $user_report->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')];
    }
}
