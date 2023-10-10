<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinesRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'tripData_id'=>'required',
            'stationFrom_id'=>'required',
            'stationTo_id'=>'required',
            'degree_id'=>'required',
            'priceGo'=>'required',
            'priceBack'=>'required',
            'cancelFee'=>'required',
            'editFee'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'tripData_id.required'=>'اسم الرحلة مطلوب',
          'stationFrom_id.required'=>'محطة الانطلاق مطلوب',
          'stationTo_id.required'=>'محطة الوصول مطلوب',
          'degree_id.required'=>'درجة الحافلة مطلوبة',
          'priceGo.required'=>'سعر الذهاب مطلوب',
          'priceBack.required'=>'سعر الذهاب والعودة مطلوب',
          'cancelFee.required'=>'غرامة إلغاء الرحلة مطلوبة',
          'editFee.required'=>'غرامة تعديل الرحلة مطلوبة',
        ];
    }
}
