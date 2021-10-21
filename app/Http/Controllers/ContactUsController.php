<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactUs;
use Validator;

class ContactUsController extends BaseController
{

    public function index()
    {
        $contacts = ContactUs::OrderBy('id','DESC')->paginate(10);
        return view('admin.contact-us.index',compact('contacts'));
    }

    public function store(Request $request){

        $error_message =    [
            'name.required'     => 'Name should be required',
            'mobile.required'   => 'Mobile Number should be required',
            'email.required'    => 'Email Id should be required',
            'email.email'       => 'Invalid Email format',
            'enquiry.required'  => 'Enquery should be required',
        ];
        $rules = [    
            'name'              => 'required',            
            'mobile'            => 'required|numeric',
            'email'             => 'required|email',
            'enquiry'           => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $error_message);
        if($validator->fails()){
            return $this->sendError(implode(", ",$validator->errors()->all()), 200);
        } 
        try
        {
            $input =  $request->all();
            \DB::beginTransaction();
            ContactUs::create($input);
            \DB::commit();
            return $this->sendResponse('Thanks for contacting, We will contact soon');            
        }
        catch (\Throwable $e)
        {
            \DB::rollback();
            return $this->sendError($e->getMessage().' on line '.$e->getLine(), 400);  
        }
    }

}
