<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookedPackageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'package_id'=>'required',
            'startDate'=>'required',
            'user_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'package_id.required'=>'اسم الاشتراك مطلوب',
            'startDate.required'=>'التاريخ مطلوب',
            'user_id.required'=>'المستخدم مطلوب',
        ];
    }


}
