<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use App\Http\Requests\Dashboard\Subcategory\SubcategoryStore;
use App\Http\Requests\Dashboard\Subcategory\SubcategoryUpdate;
use App\Http\Controllers\General\ImageController;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['subcategories'] = Subcategory::all();
        return view('dashboard.subcategory.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['latest_subcategories'] = Subcategory::orderBy('id', 'desc')->take(10)->get();
        $this->data['categories'] = Category::all();
        return view('dashboard.subcategory.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcategoryStore $request)
    {
        $subcategory = Subcategory::create($request->validated());
        return redirect()->route('subcategory.index');
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
        if (!Subcategory::find($id)) {
            return redirect()->route('subcategory.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['latest_subcategories'] = Subcategory::orderBy('id', 'desc')->take(10)->get();
        $this->data['subcategory'] = Subcategory::find($id);
        $this->data['categories'] = Category::all();
        return view('dashboard.subcategory.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubcategoryUpdate $request, $id)
    {
        if (!Subcategory::find($id)) {
            return redirect()->route('subcategory.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $subcategory = Subcategory::find($id)->update($request->all());
        return redirect()->route('subcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Subcategory::find($id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $subcategory = Subcategory::find($id);
        if (isset($subcategory->image) && $subcategory->image != '') {
            if (file_exists(storage_path('app/uploads/subcategory/org' . "/" . $subcategory->image))) {
                ImageController::delete_image_from_folder($subcategory->image, 'app/uploads/subcategory');
            }
        }
        $subcategory->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')]; 
    }
}
