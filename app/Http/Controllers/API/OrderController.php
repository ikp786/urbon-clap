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
use Illuminate\Support\Facades\Auth;
use Validator;

class OrderController extends BaseController
{
    public function index()
    {

    }

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

                    $data = [

                        'order_id'                  =>  rand(1000,9999).time().rand(10,99).auth()->user()->id,
                        'order_amount'              =>  $serviceData->service_amount,
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

                    $order = Order::create($data);
                    $cart = Cart::where('user_id',auth()->user()->id)->forceDelete();      
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
}
