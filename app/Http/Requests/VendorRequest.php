<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'=>'required',
            'phone'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'name.required'=>'الاسم مطلوب',
          'phone.required'=>'الهاتف مطلوب',
        ];
    }


}
