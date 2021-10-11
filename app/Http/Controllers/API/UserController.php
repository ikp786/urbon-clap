<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Technician;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\UserProfileCollection;

class UserController extends BaseController
{
     public function userProfile($user_id=null)
    {
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
}
