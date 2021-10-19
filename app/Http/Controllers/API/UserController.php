<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Technician;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use App\Http\Resources\UserProfileCollection;

class UserController extends BaseController
{
    public function userProfile($user_id=null){
        try
        {
            $user_details = auth()->user();
            if($user_details) {
                return $this->sendResponse('PROFILE GET SUCCESSFULLY', new UserProfileCollection($user_details));
            } else {
                return $this->sendError('UNAUTHORIZE ACCESS', 200); 
            }
        }
        catch (\Throwable $e)
        {
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
        }   
    }

    public function changePassword(Request $request){
        $error_message =    [
            'current_password.required'    => 'Current Password should be required',
            'new_password.required'    => 'New Password should be required',
        ];
        $rules = [
            'current_password' => ['required', new MatchOldPassword],
            'new_password'         => 'required',            
        ];
        $validator = Validator::make($request->all(), $rules, $error_message);   
        if($validator->fails()){
            return $this->sendError($validator->errors()->all(), 200);       
        } 
        try
        {
            $user_details = auth()->user();
            if($user_details) {
                \DB::beginTransaction();
                $change = User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
                \DB::commit();
                return $this->sendResponse('Password change succssfully');
            } else {
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
