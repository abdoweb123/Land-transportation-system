<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Calc_bookingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'trip_type'=>'required',
            'passenger_type'=>'required',
            'user_id'=>'required',
            'seatId'=>'required',
//            'payment_method'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'trip_type.required'=>'نوع الرحلة مطلوب',
          'passenger_type.required'=>'نوع الراكب مطلوب',
          'user_id.required'=>'اسم المستخدم مطلوب',
          'seatId.required'=>'يجب اختيار مقعد واحد علي الأقل',
//          'payment_method.required'=>'وسيلة الدفع مطلوبة',
        ];
    }
}
