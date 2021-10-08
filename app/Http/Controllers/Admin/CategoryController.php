<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {        
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $categories = Category::paginate(10);

        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        abort_if(Gate::denies('category_store'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $category = Category::create($request->validated());
        return redirect()->route('admin.categories.list')->with('status-success','New Category Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, 'Forbidden');

        // return view('admin.categories.show',compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $categories = Category::all();

        return view('admin.categories.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request,$id)
    {   
        abort_if(Gate::denies('category_update'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $categories = Category::all();
        $category = Category::find($id);
        $category->update($request->validated());
        return redirect()->route('admin.categories.list')->with('status-success','Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('category_destroy'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with(['status-success' => "Category Deleted"]);
    }

    public function trash(){        
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $categories = Category::onlyTrashed()->paginate();
        return view('admin.categories.trash',compact('categories'));
    }

    public function restore($id)
    {
        abort_if(Gate::denies('category_restore'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $category = Category::onlyTrashed()->find($id);
        $category->restore();
        return redirect()->back()->with(['status-success' => "Category restored."]);
    }

    public function delete($id)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $category = Category::onlyTrashed()->find($id);
        $category->forceDelete();
        return redirect()->back()->with(['status-success' => "Category Permanet Deleted"]);
    }
}
