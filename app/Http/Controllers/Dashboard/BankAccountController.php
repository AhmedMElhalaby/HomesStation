<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Http\Requests\Dashboard\BankAccount\StoreRequest;
use App\Http\Requests\Dashboard\BankAccount\UpdateRequest;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['bank_accounts'] = BankAccount::all();
        return view('dashboard.bank_accounts.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['latest_bank_accounts'] = BankAccount::orderBy('id', 'desc')->take(10)->get();
        return view('dashboard.bank_accounts.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $bank_account = BankAccount::create($request->validated());
        return redirect()->route('bank_account.index')->with('class', 'alert alert-success')->with('message', trans('dash.added_successfully'));;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!BankAccount::find($id)) {
            return redirect()->route('bank_account.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['latest_bank_accounts'] = BankAccount::orderBy('id', 'desc')->take(10)->get();
        $this->data['bank_account'] = BankAccount::find($id);
        return view('dashboard.bank_accounts.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        if (!BankAccount::find($id)) {
            return redirect()->route('bank_account.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $bank_account = BankAccount::find($id)->update($request->validated());
        return redirect()->route('bank_account.index')->with('class', 'alert alert-success')->with('message', trans('dash.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!BankAccount::find($id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $bank_account = BankAccount::find($id)->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')];
    }
}
