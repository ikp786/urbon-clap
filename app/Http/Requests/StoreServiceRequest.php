<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreServiceRequest extends FormRequest
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
            'service_amount' => 'required|numeric|between:0,99999999.99',
            'service_description' => 'required',
            'service_thumbnail' => 'required|mimes:jpg,jpeg,png,gif,svg,webp',
        ];
    }
}