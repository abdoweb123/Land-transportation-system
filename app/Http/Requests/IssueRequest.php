<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IssueRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'category_id'=>'required',
            'title'=>'required',
            'priority'=>'required',
            'type'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'category_id.required'=>'اسم المكون مطلوب',
          'title.required'=>'العنوان مطلوب',
          'priority.required'=>'حقل الأولوية مطلوب',
          'type.required'=>'النوع مطلوب',
        ];
    }
}
