<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Validator;
use App\Http\Resources\CartResource;
use App\Http\Resources\ServiceResource;
class CartController extends BaseController
{

    public function store(Request $request){

        $error_message =    [            
            'category_id.required'  => 'Category Id should be required',
            'category_id.exists'    => 'Category Id does not exist',
            'service_id.required'   => 'Service Id should be required',
            'service_id.exists'     => 'Service Id does not exist',
            'time_slot_id.required' => 'Slot Id should be required',
            'time_slot_id.exists'   => 'Slot Id does not exist',
            'booking_date.required' => 'Booking Date should be required',
        ];
        $rules = [                        
            'category_id'   => 'required|exists:categories,id',            
            'service_id'    => 'required|exists:services,id',            
            'time_slot_id'  => 'required|exists:time_slots,id',            
            'booking_date'  => 'required|date_format:Y-m-d'
        ];    
        $validator = Validator::make($request->all(), $rules, $error_message);
        if($validator->fails()){
            return $this->sendError(implode(", ",$validator->errors()->all()), 200);       
        }
        $input = $request->all();       
        $user_details = auth()->user();
        $input['user_id'] = $user_details->id;
        try {
            \DB::beginTransaction();
            $user = Cart::create($input);
            \DB::commit();
            return $this->sendResponse('Thank you for your Order');
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
        }        
    }

    public function index()
    {
        try
        {
           $user_details = auth()->user();
           $cart = Cart::with('services','time_slots')->where('user_id',$user_details->id)->get();            
           if($cart) {         
            return $data = CartResource::collection($cart);      
            return $this->sendResponse('CART GET SUCCESSFULLY', new CartResource($data));
        } else {
            return $this->sendError('UNAUTHORIZE ACCESS', 200); 
        }
    }
    catch (\Throwable $e)
    {
        return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
    }   
}

public function update(Request $request, $id){

    $error_message =    [   

        'category_id.required'  => 'Category Id should be required',
        'category_id.exists'    => 'Category Id does not exist',
        'service_id.required'   => 'Service Id should be required',
        'service_id.exists'     => 'Service Id does not exist',
        'time_slot_id.required' => 'Slot Id should be required',
        'time_slot_id.exists'   => 'Slot Id does not exist',
        'booking_date.required' => 'Booking Date should be required',
    ];
    $rules = [                        
        'category_id'   => 'required|exists:categories,id',            
        'service_id'    => 'required|exists:services,id',            
        'time_slot_id'  => 'required|exists:time_slots,id',            
        'booking_date'  => 'required|date_format:Y-m-d',
        
    ];    
    $validator = Validator::make($request->all(), $rules, $error_message);
    if($validator->fails()){
        return $this->sendError(implode(", ",$validator->errors()->all()), 200);       
    }
    $input = $request->all();       
    $user_details = auth()->user();
    $input['user_id'] = $user_details->id;
    try {
        \DB::beginTransaction();        
        $update  = Cart::findOrfail($id)->update($request->all());        
        \DB::commit();
        return $this->sendResponse('your Order is update');
    }
    catch (\Throwable $e)
    {
        \DB::rollback();
        return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
    }        
}

public function destroy($id)
{    
  try {
    \DB::beginTransaction();        
    $cart = Cart::where('id',$id)->where('user_id',auth()->user()->id)->forceDelete();      
    \DB::commit();
    return $this->sendResponse('Your cart service deleted successfully');
}
catch (\Throwable $e)
{
    \DB::rollback();
    return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
}        
}
}