<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreCategoryRequest extends FormRequest
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
            'thumbnail' => 'required',
        ];
    }
    public function messages(){

        return [
            'name.required' => 'Name filed is missing',
            // 'thumbnail.required' => 'Catrgory Thumbnail is missing',
            'thumbnail.required'    => 'Catrgory Thumbnail should be required',
            'mimes.required'                => 'Image format jpg,jpeg,png,gif,svg,webp',

        ];
    }
}
