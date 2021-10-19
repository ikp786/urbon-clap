<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Technician;
use App\Models\Category;
use App\Models\Service;
use App\Models\Order;
use App\Models\Cart;
use App\Models\TimeSlot;
use App\Models\Notification;
use App\Models\OrderDecline;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\UserOrderResource;
use App\Http\Resources\TechnicianOrderResource;
use Illuminate\Support\Facades\Input;

class OrderController extends BaseController
{
    public function store(Request $request){

        $error_message =    [
            'mobile.required'  => 'Mobile Number should be required',
            'address.required'    => 'Address should be required',
        ];
        $rules = [
            'mobile'   => 'required',
            'address'    => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $error_message);
        if($validator->fails()){
            return $this->sendError(implode(", ",$validator->errors()->all()), 200);       
        }
        $cart = Cart::where('user_id',auth()->user()->id)->get();        
        if (isset($cart[0]->id)) {
            try {
                \DB::beginTransaction();
                foreach ($cart as $key => $value) {
                    $slotData       = TimeSlot::find($value->time_slot_id);
                    $serviceData    = Service::find($value->service_id);
                    // $totalOrderInOrderTable = Order::count();
                    $order_id  = strtoupper(substr($serviceData->name,0,2)).'-'.date('Ymd').rand(1000,9999).auth()->user()->id.Order::count()+1;
                    $data = [
                        'order_id'                  =>  $order_id,
                        'order_amount'              =>  $serviceData->service_amount,
                        'final_payment'             =>  $serviceData->service_amount,
                        'mobile'                    =>  $request->mobile,
                        'user_id'                   =>  auth()->user()->id,
                        'category_id'               =>  $value->category_id,
                        'service_id'                =>  $value->service_id,
                        'booking_date'              =>  $value->booking_date,
                        'time_slot_id'              =>  $value->time_slot_id,
                        'booking_time'              =>  $slotData->slot,
                        'description'               =>  $value->description,
                        'service_name'              =>  $serviceData->name,
                        'address'                   =>  $request->address,
                        'service_detail'            =>  json_encode($serviceData),
                        'cart_detail'               =>  json_encode($value),
                        'status'                    =>  'Pending',
                        'admin_payment_status'      =>  'Unpaid',
                    ];
                    // Save order in Order Table
                    $id = Order::create($data)->id;

                    // Save Notification In Notification Table
                    $message = 'Your order is submited successfully. order id '.$order_id;
                    Notification::create([
                        'user_id'           => auth()->user()->id,
                        'role_id'           => 2,
                        'order_id'          => $order_id,
                        'order_tbl_id'      => $id,
                        'message'           => $message,
                        'deep_link'         => 'deep_link',
                        
                    ]);

                    // Delete Lead In Cart
                    //$cart = Cart::where('user_id',auth()->user()->id)->forceDelete();      
                }
                \DB::commit();
                return $this->sendResponse('Thank you for your Order');
            }
            catch (\Throwable $e)
            {
                \DB::rollback();
                return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
            } 

        }else{
          return $this->sendError('Sorry! your Order not be placed. Because your cart is empty', 400);    
      }
  }

  public function userOrderHistory(){

    try {
      \DB::beginTransaction();
      $order = Order::with('services')->orderBy('id')->where('user_id',auth()->user()->id)->get();
      \DB::commit();
      if (!isset($order[0]->id)) {
          return $this->sendError('Sorry! order not available yet.', 400);  
      }
      return $order_lit = UserOrderResource::collection($order);
      return $this->sendResponse('Orders fetch successfully', $order_lit);
  }
  catch (\Throwable $e)
  {
      \DB::rollback();
      return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
  }
}


public function userOrderDetail($order_id){

    try {
      \DB::beginTransaction();
      $order = Order::with('services')->orderBy('id')->where('order_id',$order_id)->where('user_id',auth()->user()->id)->get();
      \DB::commit();
      if (!isset($order[0]->id)) {
          return $this->sendError('Sorry! Order Id not available.', 400);  
      }
      $order_detials = UserOrderResource::collection($order);

      return $this->sendResponse('Orders fetch successfully', $order_detials);
  }
  catch (\Throwable $e)
  {
      \DB::rollback();
      return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
  }
}

public function technicianOrderHistory($status=null){

    try {
      \DB::beginTransaction();
      $orders = Order::with('services','users','order_declines');
      if ($status != 'All'){
         $orders->where('status',$status);   
     }      
     $order = $orders->orderBy('id')
     ->get();
     \DB::commit();
     if (!isset($order[0]->id)) {
      return $this->sendError('Sorry! order not available yet.', 400);  
  }  
  foreach ($order as $key => $value) {
      if (OrderDecline::where(['technician_id' => auth()->user()->id,'order_id' => $value->order_id,'status'=> 'Decline'])->count() > 0) {  
      }else{
        $data[] = $value;
    }
}

$order_lit = TechnicianOrderResource::collection($data);
return $this->sendResponse('Orders fetch successfully', $order_lit);
}
catch (\Throwable $e)
{
  \DB::rollback();
  return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
}
}


public function technicianOrderDetail($order_id){

    try {
      \DB::beginTransaction();
      $order = Order::with('services')->orderBy('id')->where('order_id',$order_id)->where('user_id',auth()->user()->id)->get();
      \DB::commit();
      if (!isset($order[0]->id)) {
          return $this->sendError('Sorry! Order Id not available.', 400);  
      }
      $order_detials = TechnicianOrderResource::collection($order);

      return $this->sendResponse('Orders fetch successfully', $order_detials);
  }
  catch (\Throwable $e)
  {
      \DB::rollback();
      return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
  }
}


public function technicianOrderAcceptOrDecline(Request $request){


    $error_message =    [            
        'order_id.required'  => 'Order Id should be required',
        'order_id.exists'    => 'Order Id did not match exist',
        'status.required'    => 'status  does not exist',           

    ];
    $rules = [
        'order_id'   => 'required|exists:orders,order_id',            
        'status'     => 'required|in:Accept,Decline',
    ];    
    $validator = Validator::make($request->all(), $rules, $error_message);
    if($validator->fails()){
        return $this->sendError(implode(", ",$validator->errors()->all()), 200);       
    }

    try {
      \DB::beginTransaction();
      $order = Order::where('order_id',$request->order_id)->get();
      if ($request->status == 'Decline') {
          OrderDecline::create([
            'order_id'      => $request->order_id,
            'order_tbl_id'  => isset($order[0]['id']) ? $order[0]['id'] : '',
            'technician_id' => auth()->user()->id,
            'status'        => $request->status,
        ]);
          return $this->sendResponse('Orders Decline successfully');
      }else{
        OrderDecline::create([
            'order_id'      => $request->order_id,
            'order_tbl_id'  => isset($order[0]['id']) ? $order[0]['id'] : '',
            'technician_id' => auth()->user()->id,
            'status'        => $request->status,
        ]);
        Order::where('order_id', $request->order_id)->update([
            'status'        => 'Assigned',
            'technician_id' => auth()->user()->id,
        ]);
    }

    \DB::commit();
    return $this->sendResponse('Orders Assigned successfully');
}
catch (\Throwable $e)
{
  \DB::rollback();
  return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
}
}


public function startWork(Request $request){

    // dd($request);
    // $error_message =    [            
    //     'order_id.required'             => 'Order Id should be required',
    //     'order_id.exists'               => 'Order Id did not match exist',
    //     'work_picture.required'         => 'Work Picture should be required',
    //     'mimes.required'                => 'Image format jpg,jpeg,png,gif,svg,webp',

    // ];
    // $rules = [
    //     'order_id'          => 'required|exists:orders,order_id',            
    //     'work_picture'      => 'required|mimes:jpg,jpeg,png,gif,svg,webp'
    // ];    
    // $validator = Validator::make($request->all(), $rules, $error_message);
    // if($validator->fails()){
    //     return $this->sendError(implode(", ",$validator->errors()->all()), 200);       
    // }

    // get Order Details
    $orderDetail = Order::where('order_id',$request->order_id)->where('technician_id',auth()->user()->id)->get();
    // check Right Technician for this order asigned
    if(!isset($orderDetail[0]->id)){
        return $this->sendError('Sorry! wrong method', 400);
    }
    // check Order Assigned Or Not
    if ($orderDetail[0]->status != 'Assigned'){
        return $this->sendError('Sorry! this order is '.$orderDetail[0]->status, 400);
    }
    try {
        \DB::beginTransaction();      
        if($request->hasfile('work_picture')){
            foreach($request->file('work_picture') as $file){
                $fileName = rand(1000,9999).time().'_'.str_replace(" ","_",$file->getClientOriginalName());            
                $filePath = $file->storeAs('work_picture', $fileName, 'public');
            // save work image 
                OrderDetail::create([
                    'order_id'       => $request->order_id,
                    'order_tbl_id'   => $orderDetail[0]->id,
                    'work_picture'   => $fileName,
                    'work_status'    => 'Before'
                ]);
            }
        }
    // update order status 
        $update = Order::find($orderDetail[0]->id);
        $update->status = 'In-Process';
        $update->save();
        \DB::commit();
        return $this->sendResponse('Work Image uplod successfully.');
    }
    catch (\Throwable $e)
    {
      \DB::rollback();
      return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);
  }
}


public function endWork(Request $request){

    // dd($request);
    // $error_message =    [            
    //     'order_id.required'             => 'Order Id should be required',
    //     'order_id.exists'               => 'Order Id did not match exist',
    //     'work_picture.required'         => 'Work Picture should be required',
    //     'mimes.required'                => 'Image format jpg,jpeg,png,gif,svg,webp',

    // ];
    // $rules = [
    //     'order_id'          => 'required|exists:orders,order_id',            
    //     'work_picture'      => 'required|mimes:jpg,jpeg,png,gif,svg,webp'
    // ];    
    // $validator = Validator::make($request->all(), $rules, $error_message);
    // if($validator->fails()){
    //     return $this->sendError(implode(", ",$validator->errors()->all()), 200);       
    // }

    // get Order Details
    $orderDetail = Order::where('order_id',$request->order_id)->where('technician_id',auth()->user()->id)->get();
    // check Right Technician for this order asigned
    if(!isset($orderDetail[0]->id)){
        return $this->sendError('Sorry! wrong method', 400);
    }
    // check Order Assigned Or Not
    if ($orderDetail[0]->status != 'In-Process'){
        return $this->sendError('Sorry! this order is '.$orderDetail[0]->status, 400);
    }
    try {
        \DB::beginTransaction();      
        if($request->hasfile('work_picture')){
            foreach($request->file('work_picture') as $file){
                $fileName = rand(1000,9999).time().'_'.str_replace(" ","_",$file->getClientOriginalName());            
                $filePath = $file->storeAs('work_picture', $fileName, 'public');
            // save work image 
                OrderDetail::create([
                    'order_id'       => $request->order_id,
                    'order_tbl_id'   => $orderDetail[0]->id,
                    'work_picture'   => $fileName,
                    'work_status'    => 'After'
                ]);
            }
        }
        $otp = rand(1000,9999);
        // update order status 
        $update = Order::find($orderDetail[0]->id);
        $update->otp = $otp;
        if($request->additional_amount != ''){
        $update->additional_amount = $request->additional_amount;
        $finalAmount = $update->order_amount + $request->additional_amount;
        $update->final_payment = $finalAmount;
        }
        $update->save();
        $user = User::find($orderDetail[0]->user_id);
        // Sent Otp in User Mobile
        Self::send_sms_otp($user->mobile, $otp);
        \DB::commit();
        return $this->sendResponse('Work Image uploded successfully and OTP has been sent to customer mobile, please verify.');
    }
    catch (\Throwable $e)
    {
      \DB::rollback();
      return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);
  }
}


public function verifyOtpCompleteWork(Request $request){

    
    $error_message =    [            
        'order_id.required'             => 'Order Id should be required',
        'order_id.exists'               => 'Order Id did not match exist',
        'otp.required'                  => 'OTP is should be required',

    ];
    $rules = [
        'order_id'          => 'required|exists:orders,order_id',            
        'otp'          => 'required|exists:orders,otp',
    ];    
    $validator = Validator::make($request->all(), $rules, $error_message);
    if($validator->fails()){
        return $this->sendError(implode(", ",$validator->errors()->all()), 200);       
    }

    // get Order Details
    $orderDetail = Order::where('order_id',$request->order_id)->where('technician_id',auth()->user()->id)->get();
    // check Right Technician for this order asigned
    if(!isset($orderDetail[0]->id)){
        return $this->sendError('Sorry! wrong method', 400);
    }
    // check Order Assigned Or Not
    if ($orderDetail[0]->status != 'In-Process'){
        return $this->sendError('Sorry! your order is '.$orderDetail[0]->status, 400);
    }

    // check OTP
    if ($orderDetail[0]->otp != $request->otp){
        return $this->sendError('Sorry! OTP did not match.', 400);
    }

    try {
        \DB::beginTransaction();            
    // update otp status 
        $update = Order::find($orderDetail[0]->id);
        $update->otp_status = 1;
        $update->save();        
        \DB::commit();
        return $this->sendResponse('Your work successfully done.');
    }
    catch (\Throwable $e)
    {
      \DB::rollback();
      return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);
  }
}




public function send_sms_otp($mobile_number, $verification_otp)
    {
        // echo $mobile_number;die;
        $opt_url = "https://2factor.in/API/V1/fd9c6a99-19d7-11ec-a13b-0200cd936042/SMS/".$mobile_number."/".$verification_otp."/OTP_TAMPLATE";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $opt_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_PROXYPORT, "80");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        return;
    }


}