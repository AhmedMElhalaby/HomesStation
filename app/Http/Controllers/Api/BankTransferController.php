<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BankTransfer\StoreRequest;
use App\Http\Requests\Api\BankTransfer\TransactionStoreRequest;
use App\Models\BankTransfer;
use App\User;

class BankTransferController extends MasterController
{
    public function send(StoreRequest $request)
    {
        if (!User::find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $bank_transfer = BankTransfer::create($request->validated() + ['user_id' => $request->user()->id]);
        return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => null], 200);
    }
    
    public function send_transaction(TransactionStoreRequest $request)
    {
        if (!User::find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $transaction = \App\Models\Transactions::create($request->validated() + ['user_id' => $request->user()->id]);
        return response()->json(['status' => 'true', 'message' => trans('app.subscription_renewed_successfully'), 'data' => null], 200);
    }
}
