<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeatRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'slug'=>'required',
            'length'=>'required',
            'width'=>'required',
            'busType_id'=>'required',
        ];
    }


    public function messages()
    {
        return [
            'slug.required'=>'عدد مقاعد الحافلة مطلوب',
            'length.required'=>'طول الحافلة مطلوب',
            'width.required'=>'عرض الحافلة مطلوب',
            'busType_id.required'=>'اسم الحافلة مطلوب',
        ];
    }


}
