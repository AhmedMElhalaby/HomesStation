<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class MasterController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale(app()->getLocale());
    }
}
