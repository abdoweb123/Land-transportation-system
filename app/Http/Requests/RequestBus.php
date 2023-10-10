<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestBus extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'code'=>'required',
            'name'=>'required',
            'chassis'=>'required',
            'busModel_id'=>'required',
            'busOwner_id'=>'required',
            'motor_number'=>'required',
            'insuranceCompany_id'=>'required',
            'bank_id'=>'required',
            'busType_id'=>'required',
            'licenceStart'=>'required',
            'licenceEnd'=>'required',
            'taxesStart'=>'required',
            'taxesEnd'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'code.required'=>'كود الحافلة مطلوب',
          'name.required'=>'اسم الحافلة مطلوب',
          'chassis.required'=>'رقم الشاسيه مطلوب',
          'motor_number.required'=>'رقم الموتور مطلوب',
          'busModel_id.required'=>'موديل الحافلة مطلوب',
          'busOwner_id.required'=>'مالك الحافلة مطلوب',
          'insuranceCompany_id.required'=>'شركة التأمين مطلوب',
          'bank_id.required'=>'سم البنك مطلوب',
          'busType_id.required'=>'نوع الحافلة مطلوب',
          'licenceStart.required'=>'تاريخ بداية الرخصة مطلوب',
          'licenceEnd.required'=>'تاريخ نهاية الرخصة مطلوب',
          'taxesStart.required'=>'تاريخ بداية الضرائب مطلوب',
          'taxesEnd.required'=>'تاريخ نهاية الضرائب مطلوب',
        ];
    }
}
