<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('role_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'required|numeric',
            'service_amount' => 'required',
            'service_description' => 'required',
            // 'service_thumbnail' => 'required|mimes:jpg,jpeg,png,gif,svg,webp',
        ];
    }

    public function messages(){

        return [
            'name.required' => 'Name filed is missing',
            'category_id.required'   => 'Category Id filed is missing',
            'service_amount.required' => 'Service Amount filed is missing',
            'service_description.required' => 'Service Description filed is missing'
        ];
    }
}
