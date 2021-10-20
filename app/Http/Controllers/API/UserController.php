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
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    public function userProfile($user_id=null){
        try
        {
            $user_details = auth()->user();
            if($user_details){
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


    public function updateUserProfile(Request $request){

    $error_message =    [
        'name.required'    => 'should be required',
        'mobile.required'  => 'Mobile Number should be required',
        'email.required'  => 'Email should be required',
        'mobile.unique'    => 'Mobile has been already taken',
        'email.unique'     => 'Email has been already taken',    
    ];
    $rules = [    
        'mobile'           => 'required|unique:users,mobile,'.auth()->user()->id.',id',
        'email'            => 'required|email|unique:users,email,'.auth()->user()->id.',id',
    ];

    if(!empty($request->file('profile_pic'))) {
        $rules['profile_pic']     = 'required|mimes:jpg,jpeg,png,gif,svg,webp';
    }

    $validator = Validator::make($request->all(), $rules, $error_message);   
    if($validator->fails()){
        return $this->sendError($validator->errors()->all(), 200);       
    } 
try
{
    $technician = auth()->user();
    $input = $request->all();
    // dd($input);
    if($technician){
        \DB::beginTransaction();
        $technician = User::find(auth()->user()->id);
        if(!empty($request->file('profile_pic'))){
           if($request->profile_pic){
               if(Storage::disk('public')->exists('technician_image/'.$technician->profile_pic)){
                Storage::disk('public')->delete('technician_image/'.$technician->profile_pic); 
            }
            $fileName = time().'_'.auth()->user()->id.'_'.str_replace(" ","_",$request->profile_pic->getClientOriginalName());
            $filePath = $request->file('profile_pic')->storeAs('technician_image', $fileName, 'public');
            $input['profile_pic'] = $fileName;
        }
    }
    $technician->update(array_filter($input));    
    \DB::commit();
    return $this->sendResponse('Profile update succssfully');
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


public function changeOnlineStatus(){
    try
    {
        \DB::beginTransaction();
        $change = User::find(auth()->user()->id)->update(['online_status'=> auth()->user()->online_status == 'Online' ? 'Offline' : 'Online' ]);
        \DB::commit();
        return $this->sendResponse('Online Status change succssfully');

    }
    catch (\Throwable $e)
    {
        \DB::rollback();
        return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
    } 
}

}
