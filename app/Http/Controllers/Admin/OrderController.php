<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Technician;
use App\Models\Category;
use App\Models\Service;
use App\Models\Order;
use App\Models\Cart;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Auth;
use Validator;

class OrderController extends Controller
{

    function __construct()
    {
        $this->Order = new  Order;
    }

    function index(Request $request){

        $order = Order::with('users','categories','services','technicians');        
        if (isset($request->mobile) && !empty($request->mobile)) {
            $order->where('mobile', 'LIKE', "%".$request->mobile."%");
        }        
        if (isset($request->order_id) && !empty($request->order_id)) {             
            $order->where('order_id', 'LIKE', "%".$request->order_id."%");
        }        
        if (isset($request->category_id) && !empty($request->category_id)) {
            $order->where('category_id', 'LIKE', "%".$request->category_id."%");
        }
        if (isset($request->service_id) && !empty($request->service_id)) {
            $order->where('service_id', 'LIKE', "%".$request->service_id."%");
        }
        if (isset($request->status) && !empty($request->status)) {
            $order->where('status', 'LIKE', "%".$request->status."%");
        }        
        if (isset($request->technician_id) && !empty($request->technician_id)) {
            $order->where('technician_id', 'LIKE', "%".$request->technician_id."%");
        }
        if (isset($request->time_slot_id) && !empty($request->time_slot_id)) {
            $order->where('time_slot_id', 'LIKE', "%".$request->time_slot_id."%");
        }
        if (isset($request->start_date) && !empty($request->start_date)) {
            $order->where('booking_date', '>=', $request->start_date);
        }
        if (isset($request->end_date) && !empty($request->end_date)) {
            $order->where('booking_date', '<=', $request->end_date);
        }

        $orders = $order->orderBy('id')->paginate(10);
        $categories = Category::where('status','Active')->pluck('name', 'id');
        $services = Service::where('status','Active')->pluck('name', 'id');
        $technicians = Technician::where('status','Active')->where('role_id',3)->pluck('name', 'id');
        $timeslots = TimeSlot::pluck('slot', 'id');
        $data = compact('orders','request','categories','services','technicians','timeslots');
        return view('admin.orders.index',$data);
    }

    function detail($order_id){

        $orders = Order::with('users','categories','services','technicians')->where('order_id',$order_id)->get();
        if (!isset($orders[0]->id)) {
         return redirect()->back()->with(['status-danger' => "Sorry! wrong method."]);
     }  
     $order = $orders[0];

     return view('admin.orders.show',compact('order'));
 }

 public function chageStatus(Request $request) {         
    if(request()->ajax()){
        $order = Order::find($request->id);            
        $order->status = $request->status; 
        $order->save(); 
        return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
    }
}


public function adminPaymentReceivedStatus(Request $request) { 
    if(request()->ajax()){
        $order = Order::find($request->id);
        $order->admin_payment_status = $request->status; 
        $order->save(); 
        return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
    }
}

public function fetchTechniciansByCategory(Request $request)
{
    // echo $request->category_id.'qqq';die;
    $data['technicians'] = Technician::where("category_id",$request->category_id)->get(["name", "id"]);
    return response()->json($data);
}

public function assignOrder(Request $request)
{
    $order = Order::find($request->id);
    $order->technician_id    =  $request->technician_id;
    $order->status           =  $request->status;
    $order->status_change_by =  Auth::user()->id;
    $order->save();

    return redirect()->back()->with(['status-success' => "Your Lead Assigned to Technician successfully."]);

}


}
