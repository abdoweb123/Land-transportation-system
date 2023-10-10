<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title'=>'required',
            'total'=>'required|numeric',
            'sub_total'=>'numeric',
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'اسم الرحلة مطلوب',
            'total.required'=>'المبلغ الكلي مطلوب',
            'total.numeric'=>'المبلغ الكلي يجب أن يكون رقما',
            'sub_total.numeric'=>'المبلغ بعد التخفيض يجب أن يكون رقما',
        ];
    }


}
