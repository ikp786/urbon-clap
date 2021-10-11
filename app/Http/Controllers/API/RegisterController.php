<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Technician;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\UserProfileCollection;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function userRegister(Request $request){

        $error_message =    [
            'name.required'    => 'Name should be required',
            'name.max'         => 'Name max length 32 character',
            'email.required'=> 'Email should be required',
            'email.unique'  => 'Email address has been taken',
            'mobile.required'=> 'Mobile number should be required',
            'mobile.unique'  => 'Mobile number has been taken',                        
            'password.required' => 'Password should be required'
        ];

        $rules = [
            'name'             => 'required|max:32',
            'email'         => 'required|email|unique:users,email',
            'mobile'         => 'required|unique:users,mobile',
            'password'      => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $error_message);
        if($validator->fails()){
            return $this->sendError(implode(", ",$validator->errors()->all()), 200);       
        }
        $input = $request->all();       
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = 2;
        
        try {
            \DB::beginTransaction();
            $user = User::create($input);
            \DB::commit();
            return $this->sendResponse('ACCOUNT CREATED SUCCESSFULLY');
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
        }        
        
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function userLogin(Request $request)
    {
        $error_message =    [
            'mobile.required'    => 'Mobile number should be required',
            'password.required' => 'Password should be required',
        ];

        $rules = [
            'mobile'         => 'required',
            'password'      => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $error_message);   
        if($validator->fails()){
            return $this->sendError($validator->errors()->all(), 200);       
        }        
        try
        {   
            if (auth()->attempt(['mobile' => $request->mobile, 'password' => $request->password])) {
                $access_token       = auth()->user()->createToken(auth()->user()->name)->accessToken;                
                // dd(auth()->user());
                return $this->sendResponse('LOGGED IN SUCCESSFULLY', ['access_token' => $access_token]);
            } else {
                return $this->sendError('INVALID VERIFACTION CODE', 200); 
            }
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}