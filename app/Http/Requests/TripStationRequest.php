<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripStationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'station_id'=>'required',
            'tripData_id'=>'required',
            'type'=>'required',
            'timeInMinutes'=>'required|numeric',
            'distance'=>'required|numeric',
            'rank'=>'required|numeric',
            'printTimes'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return [
          'station_id.required'=>'اسم المحطة مطلوب',
          'tripData_id.required'=>'اسم الرحلة مطلوب',
          'type.required'=>'نوع المحطة مطلوب',
          'timeInMinutes.required'=>'الوقت المستغرق للوصول لهذه المحطة مطلوب',
          'timeInMinutes.numeric'=>'الوقت المستغرق يجب أن يكون رقما',
          'distance.required'=>'المسافة المقطوعة للوصول لهذه المحطة مطلوب',
          'distance.numeric'=>'المسافة المقطوعة يجب أن يكون رقما',
          'rank.required'=>'ترتيب الرحلة مطلوب',
          'rank.numeric'=>'ترتيب الرحلة يجب أن يكون رقما',
          'rank.unique'=>'هذا الترتيب موجود بالفعل',
          'printTimes.required'=>'عدد مرات طباعة اللوحة مطلوب',
          'printTimes.numeric'=>'عدد مرات طباعة اللوحة يجب أن تكون رقما',
        ];
    }
}
