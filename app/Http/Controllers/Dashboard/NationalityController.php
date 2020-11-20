<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nationality;
use App\Http\Requests\Dashboard\Nationality\NationalityStore;
use App\Http\Requests\Dashboard\Nationality\NationalityUpdate;

class NationalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['nationalities'] = Nationality::all();
        return view('dashboard.nationality.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['latest_nationalities'] = Nationality::orderBy('id', 'desc')->take(10)->get();
        return view('dashboard.nationality.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NationalityStore $request)
    {
        $nationality = Nationality::create($request->validated());
        return redirect()->route('nationality.index');
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
        if (!Nationality::find($id)) {
            return redirect()->route('nationality.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['latest_nationalities'] = Nationality::orderBy('id', 'desc')->take(10)->get();
        $this->data['nationality'] = Nationality::find($id);
        return view('dashboard.nationality.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NationalityUpdate $request, $id)
    {
        if (!Nationality::find($id)) {
            return redirect()->route('nationality.edit', $id)->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $nationality = Nationality::find($id)->update($request->all());
        return redirect()->route('nationality.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Nationality::find($id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $nationality = Nationality::find($id)->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')];
    }
}
