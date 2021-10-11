<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class updateTechnicianRequest extends FormRequest
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
                Rule::unique('users')->ignore($_REQUEST['user_id']),
            ],
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('users')->ignore($_REQUEST['user_id']),
            ],
            'password' => 'nullable|min:6|max:20',
            // 'role_id' => 'required|exists:roles,id',
            'category_id' => 'required',
            // 'profile_pic' => 'required',
        ];
    }
}
