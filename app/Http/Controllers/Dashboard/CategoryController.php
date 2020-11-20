<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Dashboard\Category\CategoryStore;
use App\Http\Requests\Dashboard\Category\CategoryUpdate;
use App\Http\Controllers\General\ImageController;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['categories'] = Category::all();
        return view('dashboard.category.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['latest_categories'] = Category::orderBy('id', 'desc')->take(10)->get();
        return view('dashboard.category.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStore $request)
    {
        $category = Category::create($request->validated());
        return redirect()->route('category.index');
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
        if (!Category::find($id)) {
            return redirect()->route('category.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $this->data['latest_categories'] = Category::orderBy('id', 'desc')->take(10)->get();
        $this->data['category'] = Category::find($id);
        return view('dashboard.category.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdate $request, $id)
    {
        if (!Category::find($id)) {
            return redirect()->route('category.index')->with('class', 'alert alert-danger')->with('message', trans('dash.try_2_access_not_found_content'));
        }
        $category = Category::find($id)->update($request->validated());
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Category::find($id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $category = Category::find($id);
        if(isset($category->image) && $category->image  != ''){
            if (file_exists(storage_path('app/uploads/category/org' . "/" . $category->image))) {
                ImageController::delete_image_from_folder($category->image, 'app/uploads/category');
            }
        }
        $category->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')]; 
    }
}
