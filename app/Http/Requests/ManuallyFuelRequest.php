<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManuallyFuelRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'bus_id'=>'required',
            'distance'=>'required|numeric',
            'comments'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'bus_id.required'=>'كود الحافلة مطلوب',
          'distance.required'=>'المسافة مطلوبة',
          'distance.numeric'=>'المسافة يجب أن تكون رقما',
          'comments.required'=>'التعليق مطلوب',
        ];
    }


}
