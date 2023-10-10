<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRegister extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:8',
            'type' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صالحا',
            'email.unique' => 'هذا البريد موجود بالفعل',
            'password.required' => 'كلمة السر مطلوبة',
            'password.min' => 'كلمة السر يجب أن تتكون من 8 أحرف علي الأقل',
            'type.required' => 'نوع المستخدم مطلوب',
        ];
    }

}
