<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreBannerMultipleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('banner_multiple_store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [            
            'banner' => 'required',
        ];
    }

     public function messages(){

        return [
            
            'banner.required'    => 'Banner  should be required',
            'mimes.required'     => 'Image format jpg,jpeg,png,gif,svg,webp',

        ];
    }
}
