<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPhotoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->User = new User;
    }


    public function index(Request $request)
    {
        abort_if(Gate::denies('users_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        // $users = User::where('role_id',2)->with('role')->paginate(10)->appends($request->query());
        $users  = $this->User->user_list($request->name,$request->email,$request->mobile);

        // $users = User::where('role_id',2)->with('role')->paginate(10)->appends($request->query());
        return view('admin.users.index',compact('users','request'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $roles = Role::pluck('title','id');
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $input = $request->validated();
        if($request->profile_pic) {
         $fileName = time().'_'.str_replace(" ","_",$request->profile_pic->getClientOriginalName());
         $filePath = $request->file('profile_pic')->storeAs('user_image', $fileName, 'public');
         $input['profile_pic'] = $fileName;
     }
     if (isset($request->status) && $request->status == 'Active'){
        $input['status'] = 'Active';
    }else{
        $input['status'] = 'Inactive';
    }   
    $input['role_id'] = 2;   

    User::create($input);
    return redirect()->route('users.index')->with(['status-success' => "New User Created"]);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, 'Forbidden');

        return view('admin.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $roles = Role::pluck('title','id');
        return view('admin.users.edit',compact('user','roles'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $input = $request->all();
        if($request->profile_pic) {
           $fileName = time().'_'.str_replace(" ","_",$request->profile_pic->getClientOriginalName());
           $filePath = $request->file('profile_pic')->storeAs('user_image', $fileName, 'public');
           $input['profile_pic'] = $fileName;
       }
       if (isset($request->status) && $request->status == 'Active') {
        $input['status'] = 'Active';
    }else{
        $input['status'] = 'Inactive';
    }   
        $user->update(array_filter($input));
        return redirect()->route('users.index')->with(['status-success' => "User Updated"]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $user->delete();
        return redirect()->back()->with(['status-success' => "User Deleted"]);
    }

    public function trash(){        

        abort_if(Gate::denies('users_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $users = User::where('role_id',2)->onlyTrashed()->paginate();
        return view('admin.users.trash',compact('users'));
    }

    public function restore($id)
    {
        abort_if(Gate::denies('user_restore'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $category = User::onlyTrashed()->find($id);
        $category->restore();
        return redirect()->back()->with(['status-success' => "User restored."]);
    }

    public function delete($id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');
        
        $User = User::onlyTrashed()->find($id);
        $User->forceDelete();
        return redirect()->back()->with(['status-success' => "User Permanet Deleted"]);
    }

    public function chageStatus(Request $request) { 
        if(request()->ajax()){
            $User = User::find($request->id);
            $User->status = $request->status; 
            $User->save(); 
            return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
        }
    }
}
