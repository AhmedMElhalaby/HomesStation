<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubcategoryTag;
use App\Models\Category;
use App\Http\Requests\Dashboard\SubcategoryTag\SubcategoryTagStore;
use App\Http\Requests\Dashboard\SubcategoryTag\SubcategoryTagUpdate;

class SubcategoryTagController extends MasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['subcategory_tags'] = SubcategoryTag::all();
        return view('dashboard.subcategory_tags.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['latest_subcategory_tags'] = SubcategoryTag::orderBy('id', 'desc')->take(10)->get();
        $this->data['categories'] = Category::all();
        return view('dashboard.subcategory_tags.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcategoryTagStore $request)
    {
        $subcategory_tag = SubcategoryTag::create($request->validated());
        return redirect()->route('subcategory_tag.index');
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
        if (!SubcategoryTag::find($id)) {
            return redirect()->route('subcategory.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['latest_subcategory_tags'] = SubcategoryTag::orderBy('id', 'desc')->take(10)->get();
        $this->data['subcategory_tag'] = SubcategoryTag::find($id);
        $this->data['categories'] = Category::all();
        return view('dashboard.subcategory_tags.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubcategoryTagUpdate $request, $id)
    {
        if (!SubcategoryTag::find($id)) {
            return redirect()->route('subcategory_tag.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $subcategory_tag = SubcategoryTag::find($id)->update($request->validated());
        return redirect()->route('subcategory_tag.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!SubcategoryTag::find($id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $subcategory_tag = SubcategoryTag::find($id);        
        $subcategory_tag->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')];
    }
}
