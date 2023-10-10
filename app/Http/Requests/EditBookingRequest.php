<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditBookingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
//            'trip_type'=>'required',
            'seatId'=>'required',
            'seatId.*'=>'required',
        ];
    }

    public function messages()
    {
        return [
//          'trip_type.required'=>'برجاء تحديد نوع الرحلة',
          'seatId.required'=>'برجاء تحديد المقاعد المراد تغييرها',
        ];
    }


}
