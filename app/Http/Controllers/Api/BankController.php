<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankAccount as BankAccountResource;
use App\Models\BankAccount;

class BankController extends MasterController
{
    public function index(Request $request)
    {
        return response(['status' => 'true', 'message' => '', 'data' => BankAccountResource::collection(BankAccount::all())], 200);
    }
}
