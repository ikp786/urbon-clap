<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Http\Requests\StoreTimeSlotRequest;
use App\Http\Requests\UpdateTimeSlotRequest;
use App\Models\TimeSlot;
// use Illuminate\Support\Facades\Gate;
// use Illuminate\Http\Response;

class TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        abort_if(Gate::denies('timeslot_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

        $timeslots = TimeSlot::paginate(10);

        return view('admin.timeslots.index',compact('timeslots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('timeslot_create'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        return view('admin.timeslots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimeSlotRequest $request)
    {
        abort_if(Gate::denies('timeslot_store'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $input = $request->validated();      
        if (isset($request->status) && $request->status == 'Active') {
            $input['status'] = 'Active';
        }else{
            $input['status'] = 'Inactive';
        }

        $TimeSlot = TimeSlot::create($input);
        return redirect()->route('timeslots.index')->with('status-success','New TimeSlot Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_if(Gate::denies('TimeSlot_show'), Response::HTTP_FORBIDDEN, 'Forbidden');

        // return view('admin.timeslots.show',compact('timeslots'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        abort_if(Gate::denies('timeslot_edit'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $timeslots = TimeSlot::find($id);

        return view('admin.timeslots.edit', compact('timeslots'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTimeSlotRequest $request,$id)
    {   
        abort_if(Gate::denies('timeslot_update'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $input = $request->all();        
        $TimeSlot = TimeSlot::find($id);                
        if (isset($request->status) && $request->status == 'Active') {
            $input['status'] = 'Active';
        }else{
            $input['status'] = 'Inactive';
        }
        $TimeSlot->update($input);
        return redirect()->route('timeslots.index')->with('status-success','TimeSlot Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('timeslot_destroy'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $TimeSlot = TimeSlot::find($id);
        $TimeSlot->delete();
        return redirect()->back()->with(['status-success' => "TimeSlot Deleted"]);
    }

    public function trash(){        

        abort_if(Gate::denies('timeslot_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $timeslots = TimeSlot::onlyTrashed()->paginate();
        return view('admin.timeslots.trash',compact('timeslots'));
    }

    public function restore($id)
    {
        abort_if(Gate::denies('timeslot_restore'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $TimeSlot = TimeSlot::onlyTrashed()->find($id);
        $TimeSlot->restore();
        return redirect()->back()->with(['status-success' => "TimeSlot restored."]);
    }

    public function delete($id)
    {
        abort_if(Gate::denies('timeslot_delete'), Response::HTTP_FORBIDDEN, 'Forbidden');        
        $TimeSlot = TimeSlot::onlyTrashed()->find($id);
        $TimeSlot->forceDelete();
        return redirect()->back()->with(['status-success' => "TimeSlot Permanet Deleted"]);
    }

    public function chageStatus(Request $request) { 
        if(request()->ajax()){
            $TimeSlot = TimeSlot::find($request->id);
            $TimeSlot->status = $request->status; 
            $TimeSlot->save(); 
            return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
        }
    }
}
