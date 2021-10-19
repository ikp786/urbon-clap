<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreBannerMultipleRequest;
//use App\Http\Requests\UpdateBannerMultipleRequest;
use App\Models\Role;
use App\Models\BannerMultiple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerMultipleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        abort_if(Gate::denies('banner_multiple_access'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        $banners = BannerMultiple::OrderBy('id','DESC')->paginate(10);
        return view('admin.banner-multiples.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('banner_multiple_create'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        return view('admin.banner-multiples.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannerMultipleRequest $request)
    {   
        abort_if(Gate::denies('banner_multiple_store'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $input = $request->all();
        if($request->banner) {
         $fileName = time().'_'.str_replace(" ","_",$request->banner->getClientOriginalName());
         $filePath = $request->file('banner')->storeAs('banner', $fileName, 'public');
         $input['banner'] = $fileName;
     }
     if (isset($request->status) && $request->status == 'Active') {
        $input['status'] = 'Active';
    }else{
        $input['status'] = 'Inactive';
    }       
    BannerMultiple::create($input);
    return redirect()->route('banner-multiples.index')->with(['status-success' => "New Banner save successfully"]);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('banner_multiple_show'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $banner = BannerMultiple::find($id);
        return view('admin.banner-multiples.show',compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('banner_multiple_edit'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $banner = BannerMultiple::where('id',$id)->find($id);        
        return view('admin.banner-multiples.edit',compact('banner'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        abort_if(Gate::denies('banner_multiple_update'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $banner = BannerMultiple::find($id);
        $input = $request->all();  
        if(!empty($request->file('banner'))) 
        {
            if(Storage::disk('public')->exists('banner/'.$banner->banner))
            {
                Storage::disk('public')->delete('banner/'.$banner->banner); 
            }

            $fileName = time().'_'.str_replace(" ","_",$request->banner->getClientOriginalName());
            $filePath = $request->file('banner')->storeAs('banner', $fileName, 'public');
            $input['banner'] = $fileName;
        }
        if (isset($request->status) && $request->status == 'Active') {
            $input['status'] = 'Active';
        }else{
            $input['status'] = 'Inactive';
        }       
    // $input['online_status'] = 'Online';
        $banner->update(array_filter($input));
        return redirect()->route('banner-multiples.index')->with(['status-success' => "Banners Updated"]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('banner_multiple_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $user = BannerMultiple::find($id);
        $user->delete();
        return redirect()->back()->with(['status-success' => "Banners Deleted"]);
    }

    public function trash(){        

        abort_if(Gate::denies('banner_multiple_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $banners = BannerMultiple::onlyTrashed()->paginate(10);
        return view('admin.banner-multiples.trash',compact('banners'));
    }

    public function restore($id)
    {
        abort_if(Gate::denies('banner_multiple_restore'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $category = BannerMultiple::onlyTrashed()->find($id);
        $category->restore();
        return redirect()->back()->with(['status-success' => "Banners restored."]);
    }

    public function delete($id)
    {
        abort_if(Gate::denies('banner_multiple_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        $banner = BannerMultiple::onlyTrashed()->find($id);
        $banner->forceDelete();
        if(Storage::disk('public')->exists('banner/'.$banner->banner))
        {
            Storage::disk('public')->delete('banner/'.$banner->banner); 
        }
        return redirect()->back()->with(['status-success' => "Banners Permanet Deleted"]);
    }

    public function chageStatus(Request $request) { 
        if(request()->ajax()){
            $technician = BannerMultiple::find($request->id);
            $technician->status = $request->status; 
            $technician->save(); 
            return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
        }
    }
}
