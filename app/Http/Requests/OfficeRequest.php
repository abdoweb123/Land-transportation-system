<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name_ar'=>'required',
            'name_en'=>'required',
            'station_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'name_ar.required'=>'الاسم باللغة العربية مطلوب',
          'name_en.required'=>'الاسم باللغة الإنجليزية مطلوب',
          'station_id.required'=>'اسم المحطة مطلوب'
        ];
    }


}
