<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title'=>'required',
            'max_trips'=>'required',
            'stationFrom_id'=>'required',
            'stationTo_id'=>'required',
            'max_duration'=>'required|numeric',
            'total'=>'required|numeric',
            'sub_total'=>'numeric',
            'type'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'اسم الرحلة مطلوب',
            'max_trips.required'=>'أقصى عدد للرحلات مطلوب',
            'stationFrom_id.required'=>'محطة الانطلاق مطلوبة',
            'stationTo_id.required'=>'محطة الوصول مطلوبة',
            'max_duration.required'=>'مدة الاشتراك بالأيام مطلوبة',
            'total.required'=>'المبلغ الكلي مطلوب',
            'max_duration.numeric'=>'مدة الاشتراك يجب أن تكون رقما',
            'total.numeric'=>'المبلغ الكلي يجب أن يكون رقما',
            'sub_total.numeric'=>'المبلغ بعد التخفيض يجب أن يكون رقما',
            'type.required'=>'نوع الرحلة مطلوبة',
        ];
    }


}
