<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class StoreTechnicianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:200',
            'mobile' => [
                'required',                
                'max:10',
                Rule::unique('users'),//->ignore($this->user),
            ],
            'email' => [
                'required',
                'email',
                'max:200',
                //Rule::unique('users')->ignore($this->user),
            ],
            'password' => 'required|min:6|max:20',
            // 'role_id' => 'required|exists:roles,id',
            'category_id' => 'required',
            'profile_pic',
        ];
    }

    public function messages()
    {
        return [

            'name.required' => 'Name is missing',
            'name.|string|min:3|max:200' => 'Name length min 2 and max 200 required in string',
            
            'email.email' => 'Please enter a valid email',
            'email.max:200' => 'email max length 200',
            // 'password' => 'required|password_confirmation|min:6|max:20',
            // 'role_id' => 'required|exists:roles,id',
            'category_id' => 'required',
        ];
    }
}
