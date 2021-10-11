<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
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
    public function index()
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
        $input = $request->validated();
        if($request->thumbnail) {
         $fileName = time().'_'.str_replace(" ","_",$request->thumbnail->getClientOriginalName());
         $filePath = $request->file('thumbnail')->storeAs('category', $fileName, 'public');
         $input['thumbnail'] = $fileName;
     }
       if (isset($request->status) && $request->status == 'Active') {
        $input['status'] = 'Active';
    }else{
        $input['status'] = 'Inactive';
    }

     $category = Category::create($input);
     return redirect()->route('categories.index')->with('status-success','New Category Created');
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
        $categories = Category::find($id);

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
        // $categories = Category::all();
        // $category = Category::find($id);
        // $category->update($request->validated());

        $input = $request->all();        
        $category = Category::find($id);        
        if($request->thumbnail) {
         $fileName = time().'_'.str_replace(" ","_",$request->thumbnail->getClientOriginalName());
         $filePath = $request->file('thumbnail')->storeAs('category', $fileName, 'public');
         $input['thumbnail'] = $fileName;           
     }else{
        unset($input['thumbnail']);
    }   
    if (isset($request->status) && $request->status == 'Active') {
        $input['status'] = 'Active';
    }else{
        $input['status'] = 'Inactive';
    }
    $category->update($input);
    return redirect()->route('categories.index')->with('status-success','Category Updated');
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
        $service = Service::where('id',$id)->get();
        $service_id = isset($service[0]->id) ? 1 : 0;
        if ($service_id == 1) {
            return redirect()->back()->with(['status-danger' => "this category cannot be deleted. Because this category foreign key save in Services master"]);
        }
        $category = Category::onlyTrashed()->find($id);
        $category->forceDelete();
        return redirect()->back()->with(['status-success' => "Category Permanet Deleted"]);
    }

    public function chageStatus(Request $request) { 
        if(request()->ajax()){
            $category = Category::find($request->id);
            $category->status = $request->status; 
            $category->save(); 
            return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
        }
    }
}
