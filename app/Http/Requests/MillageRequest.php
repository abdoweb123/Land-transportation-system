<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MillageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'type'=>'required',
            'minimum'=>'required|numeric',
            'coupon_id'=>'required'
        ];
    }

    public function messages()
    {
        return [
          'type.required'=>'نوع الخصم مطلوب',
          'minimum.required'=>'عدد الوحدات مطلوب',
          'minimum.numeric'=>'عدد الوحدات يجب أن تكون رقما',
          'coupon_id.required'=>'كود الكوبون مطلوب'
        ];
    }


}
