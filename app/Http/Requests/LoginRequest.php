<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email'=>'required',
            'password'=>'required',
//            'type'=>'required|in:superVisor,admin,employee,web',
        ];
    }

    public function messages()
    {
        return [
          'email.required'=>' البريد الإلكتروني مطلوب',
          'password.required'=>'كلمة المرور مطلوبة',
//          'type.required'=>'نوع المستخدم مطلوب',
        ];
    }
}
