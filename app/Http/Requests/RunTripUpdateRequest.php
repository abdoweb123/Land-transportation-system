<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RunTripUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'tripData_id'=>'required',
            'driver_id'=>'required',
            'bus_id'=>'required',
            'type'=>'required',
            'startDate'=>'required',
            'startTime'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'tripData_id.required'=>'اسم الرحلة مطلوب',
          'driver_id.required'=>'اسم السائق مطلوب',
          'bus_id.required'=>'اسم الحافلة مطلوب',
          'type.required'=>'نوع الحافلة',
          'startDate.required'=>'تاريخ البداية مطلوب',
          'startTime.required'=>'توقيت الرحلة مطلوب',
        ];
    }
}
