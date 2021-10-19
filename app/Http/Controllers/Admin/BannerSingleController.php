<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\BannerSingle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerSingleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('banner_single_access'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        $banners = BannerSingle::OrderBy('id','DESC')->paginate(10);
        return view('admin.banner-singles.index',compact('banners'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('banner_single_create'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        return view('admin.banner-singles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('banner_single_show'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $banner = BannerSingle::find($id);
        return view('admin.banner-singles.show',compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('banner_single_edit'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $banner = BannerSingle::where('id',$id)->find($id);        
        return view('admin.banner-singles.edit',compact('banner'));
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
        abort_if(Gate::denies('banner_single_update'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $banner = BannerSingle::find($id);
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
        $banner->update(array_filter($input));
        return redirect()->route('banner-singles.index')->with(['status-success' => "Banners Updated"]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // abort_if(Gate::denies('banner_single_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');
        // $user = BannerSingle::find($id);
        // $user->delete();
        // return redirect()->back()->with(['status-success' => "Banners Deleted"]);
    }

    public function trash(){        

        // abort_if(Gate::denies('banner_single_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        // $banners = BannerSingle::onlyTrashed()->paginate(10);
        // return view('admin.banner-singles.trash',compact('banners'));
    }

    public function restore($id)
    {
        // abort_if(Gate::denies('banner_single_restore'), Response::HTTP_FORBIDDEN, 'Forbidden');
        // $category = BannerSingle::onlyTrashed()->find($id);
        // $category->restore();
        // return redirect()->back()->with(['status-success' => "Banners restored."]);
    }

    public function delete($id)
    {
        // abort_if(Gate::denies('banner_single_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        // $banner = BannerSingle::onlyTrashed()->find($id);
        // $banner->forceDelete();
        // if(Storage::disk('public')->exists('banner/'.$banner->banner))
        // {
        //     Storage::disk('public')->delete('banner/'.$banner->banner); 
        // }
        // return redirect()->back()->with(['status-success' => "Banners Permanet Deleted"]);
    }

    public function chageStatus(Request $request) { 
        if(request()->ajax()){
            $banner = BannerSingle::find($request->id);
            $banner->status = $request->status; 
            $banner->save(); 
            return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
        }
    }
}
