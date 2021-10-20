<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Ratting;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Validator;

class RattingController extends BaseController
{
    public function store(Request $request){

        $error_message =    [
            'order_id.required'     => 'Order Id should be required',
            'order_id.exists'       => 'Order Id does not exist',
            'ratting_star.required' => 'Ratting star should be required',
            'ratting_star.numeric'  => 'Ratting star should be Numeric value',
            'comment.required'      => 'Commet should be required',
        ];
        $rules = [    
            'order_id'              => 'required|exists:orders,order_id',            
            'ratting_star'          => 'required|numeric',
            'comment'               => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $error_message);
        if($validator->fails()){
            return $this->sendError(implode(", ",$validator->errors()->all()), 200);
        } 
        try
        {
            // get Order Details
            $order = Order::where(['order_id' => $request->order_id])->get();
            if ($order[0]->user_id != auth()->user()->id){  
                return $this->sendError('Sorry! you have not permission to ratting this order.', 400);  
            }
            $input = $request->all();    
            $input['order_tbl_id']   = $order[0]->id;
            $input['technician_id']  = $order[0]->technician_id;            
            $input['user_id']        = auth()->user()->id;            
            if(auth()->user()){
                \DB::beginTransaction();
                Ratting::create($input);
                \DB::commit();
                return $this->sendResponse('Ratting save succssfully');
            }else{
                return $this->sendError('UNAUTHORIZE ACCESS', 200); 
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }

}
