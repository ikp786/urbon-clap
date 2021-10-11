<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $services = Service::with('categories')->paginate(10);
        return view('admin.services.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $categories = Category::all()->pluck('name', 'id');
        return view('admin.services.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        abort_if(Gate::denies('service_store'), Response::HTTP_FORBIDDEN, 'Forbidden');    
        $input = $request->validated();
        if($request->service_thumbnail) {
           $fileName = time().'_'.str_replace(" ","_",$request->service_thumbnail->getClientOriginalName());
           $filePath = $request->file('service_thumbnail')->storeAs('service', $fileName, 'public');
           $input['service_thumbnail'] = $fileName;
       }
       if (isset($request->status) && $request->status == 'Active') {
        $input['status'] = 'Active';
    }else{
        $input['status'] = 'Inactive';
    }
    $service = Service::create($input);
    return redirect()->route('services.index')->with('status-success','New Service Created');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('service_show'), Response::HTTP_FORBIDDEN, 'Forbidden');

        return view('admin.services.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $services = Service::find($id);
        $categories = Category::all()->pluck('name', 'id');        
        return view('admin.services.edit', compact('services','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, $id)
    {
        abort_if(Gate::denies('service_update'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $input = $request->all();        
        $service = Service::find($id);        
        if($request->service_thumbnail) {
           $fileName = time().'_'.str_replace(" ","_",$request->service_thumbnail->getClientOriginalName());
           $filePath = $request->file('service_thumbnail')->storeAs('service', $fileName, 'public');
           $input['service_thumbnail'] = $fileName;           
       }else{
        unset($input['service_thumbnail']);
    }   
    if (isset($request->status) && $request->status == 'Active') {
        $input['status'] = 'Active';
    }else{
        $input['status'] = 'Inactive';
    }
    
    $service->update($input);
    return redirect()->route('services.index')->with('status-success','Service Updated');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        abort_if(Gate::denies('service_destroy'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $Service = Service::find($id);
        $Service->delete();
        return redirect()->back()->with(['status-success' => "Service Deleted"]);
    }

    public function trash(){        
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        $services = Service::onlyTrashed()->with('categories')->paginate(10);        
        return view('admin.services.trash',compact('services'));
    }

    public function restore($id)
    {
        abort_if(Gate::denies('service_restore'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        $category = Service::onlyTrashed()->find($id);
        $category->restore();
        return redirect()->back()->with(['status-success' => "Service restored."]);
    }

    public function delete($id)
    {    
    // echo 'd';die;
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        $service = Service::onlyTrashed()->find($id);   
        $service->forceDelete();
        return redirect()->back()->with(['status-success' => "Service Permanet Deleted"]);
    }

    public function chageStatus(Request $request) { 
        if(request()->ajax()){
            $service = Service::find($request->id);
            $service->status = $request->status; 
            $service->save(); 
            return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
        }
    }
}