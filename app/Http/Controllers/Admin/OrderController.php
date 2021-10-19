<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Technician;
use App\Models\Category;
use App\Models\Service;
use App\Models\Order;
use App\Models\Cart;
use App\Models\TimeSlot;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Validator;

class OrderController extends Controller
{

    function __construct()
    {
        $this->Order = new  Order;
    }

    function index(Request $request){

        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, 'Forbidden');

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

        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $orders = Order::with('users','categories','services','technicians')->where('order_id',$order_id)->get();
        if (!isset($orders[0]->id)) {
         return redirect()->back()->with(['status-danger' => "Sorry! wrong method."]);
     }  
     $order = $orders[0];

     return view('admin.orders.show',compact('order'));
 }

 public function chageStatus(Request $request) {         

    abort_if(Gate::denies('order_change_status'), Response::HTTP_FORBIDDEN, 'Forbidden');
    if(request()->ajax()){
        $order = Order::find($request->id);            
        $order->status = $request->status; 
        $order->save(); 
        $message = 'Your order is '.$request->status.' successfully. order id '.$order->order_id;
        Notification::create([
            'user_id'           => User::find($request->id)['id'],
            'role_id'           => 2,
            'order_id'          => $order->order_id,
            'order_tbl_id'      => $order->id,
            'message'           => $message,
            'deep_link'         => 'deep_link',

        ]);
        return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
    }
}   

    /**
     * If Admin receive payment by technician status change mark paid
     *     
     */

    public function adminPaymentReceivedStatus(Request $request){

        abort_if(Gate::denies('order_admin_payment_received_status'), Response::HTTP_FORBIDDEN, 'Forbidden');
        if(request()->ajax()){
            $order = Order::find($request->id);
            $order->admin_payment_status = $request->status; 
            $order->save(); 
            return response()->json(['success'=>' status change '.$request->status.' successfully.']); 
        }
    }

    /**
     * Get Technician for this category match for admin asign lead technician
     *     
     */

    public function fetchTechniciansByCategory(Request $request)
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $data['technicians'] = Technician::where("category_id",$request->category_id)->get(["name", "id"]);
        return response()->json($data);
    }

    /**
     * If nobody accept lead so admin asign manually lead Technician
     *     
     */

    public function assignOrder(Request $request)
    {   
        abort_if(Gate::denies('order_asign'), Response::HTTP_FORBIDDEN, 'Forbidden');
        $order = Order::find($request->id);
        $order->technician_id    =  $request->technician_id;
        $order->status           =  $request->status;
        $order->status_change_by =  Auth::user()->id;
        $order->save();

        // save notification in notification table
        $message = 'Your order is '.$request->status.' to technician successfully. order id '.$order->order_id;
        Notification::create([
            'user_id'           => User::find($request->id)['id'],
            'role_id'           => 2,
            'order_id'          => $order->order_id,
            'order_tbl_id'      => $order->id,
            'message'           => $message,
            'deep_link'         => 'deep_link',
        ]);
        return redirect()->back()->with(['status-success' => "Your Lead Assigned to Technician successfully."]);
    }
}