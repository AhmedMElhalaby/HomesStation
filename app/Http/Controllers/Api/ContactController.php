<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactRequest;
use App\Models\Contact;
use App\Models\Complaint;

class ContactController extends MasterController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        if ($request->header('Authorization')) {
            $this->middleware('jwt.auth');
        }
    }

    public function index(ContactRequest $request)
    {
        $data = $request->all();
        if (!$request->user()) {
            if (!$request->name)
                return response()->json(['status' => 'false', 'message' => trans('app.name_required'), 'data' => null], 422);
            if (!$request->mobile)
                return response()->json(['status' => 'false', 'message' => trans('app.mobile_required'), 'data' => null], 422);
        }else{
            $data = $request->all();
            $data['user_id'] = $request->user()->id;
            $data['name'] = $request->user()->username;
            $data['mobile'] = $request->user()->mobile;
        }
        $contact = Contact::create($data);
        return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => null], 200);
    }

    public function complaint(ContactRequest $request)
    {
        $data = $request->all();
        if (!$request->user()) {
            if (!$request->name)
                return response()->json(['status' => 'false', 'message' => trans('app.name_required'), 'data' => null], 422);
            if (!$request->mobile)
                return response()->json(['status' => 'false', 'message' => trans('app.mobile_required'), 'data' => null], 422);
        }else{
            $data = $request->all();
            $data['user_id'] = $request->user()->id;
            $data['name'] = $request->user()->username;
            $data['mobile'] = $request->user()->mobile;
        }
        $complaint = Complaint::create($data);
        return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => null], 200);
    }
}
