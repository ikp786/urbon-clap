<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreTechnicianRequest;
use App\Http\Requests\UpdateTechnicianRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Technician;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPhotoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->Technician = new Technician;
    }


    public function index(Request $request)
    {
        abort_if(Gate::denies('technician_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        
        $technicians = Technician::where('role_id',3)->with('role')->paginate(10)->appends($request->query());
        $technicians     = $this->Technician->user_list($request->name,$request->email,$request->mobile);

        return view('admin.technicians.index',compact('technicians','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('technician_create'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $categories = Category::all()->pluck('name', 'id');
        $roles = Role::where('id',3)->pluck('title','id');
        return view('admin.technicians.create',compact('roles','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTechnicianRequest $request)
    {   
        abort_if(Gate::denies('technician_store'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $input = $request->validated();
        if($request->profile_pic) {
           $fileName = time().'_'.str_replace(" ","_",$request->profile_pic->getClientOriginalName());
           $filePath = $request->file('profile_pic')->storeAs('technician_image', $fileName, 'public');
           $input['profile_pic'] = $fileName;
       }
       if (isset($request->status) && $request->status == 'Active') {
        $input['status'] = 'Active';
    }else{
        $input['status'] = 'Inactive';
    }   
    $input['role_id'] = 3;
    $input['online_status'] = 'Offline';
    Technician::create($input);
    return redirect()->route('technicians.index')->with(['status-success' => "New Technician Created"]);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('technician_show'), Response::HTTP_FORBIDDEN, 'Forbidden');
         $technician = Technician::find($id);
        return view('admin.technicians.show',compact('technician'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('technician_edit'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $technicians = Technician::where('id',$id)->find($id);
        $roles = Role::where('id',3)->pluck('title','id');
        $categories = Category::all()->pluck('name', 'id');        
        return view('admin.technicians.edit',compact('technicians','roles','categories'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnicianRequest $request,$id)
    {
        abort_if(Gate::denies('technician_update'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $technician = Technician::find($id);
        $input = $request->validated();
        if($request->profile_pic) {
           $fileName = time().'_'.str_replace(" ","_",$request->profile_pic->getClientOriginalName());
           $filePath = $request->file('profile_pic')->storeAs('technician_image', $fileName, 'public');
           $input['profile_pic'] = $fileName;
       }
       if (isset($request->status) && $request->status == 'Active') {
        $input['status'] = 'Active';
    }else{
        $input['status'] = 'Inactive';
    }       
    // $input['online_status'] = 'Online';
    $technician->update(array_filter($input));
    return redirect()->route('technicians.index')->with(['status-success' => "Technician Updated"]);
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('technician_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $user = Technician::find($id);
        $user->delete();
        return redirect()->back()->with(['status-success' => "Technician Deleted"]);
    }


    public function trash(){        

        abort_if(Gate::denies('technician_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $technicians = Technician::where('role_id',3)->onlyTrashed()->paginate();
        return view('admin.technicians.trash',compact('technicians'));
    }

    public function restore($id)
    {
        abort_if(Gate::denies('technician_restore'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $category = Technician::onlyTrashed()->find($id);
        $category->restore();
        return redirect()->back()->with(['status-success' => "Technician restored."]);
    }

    public function delete($id)
    {
        abort_if(Gate::denies('technician_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');
        
        $technician = Technician::onlyTrashed()->find($id);
        $technician->forceDelete();
        return redirect()->back()->with(['status-success' => "Technician Permanet Deleted"]);
    }

    public function chageStatus(Request $request) { 
        if(request()->ajax()){
            $technician = Technician::find($request->id);
            $technician->status = $request->status; 
            $technician->save(); 
            return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
        }
    }
}
