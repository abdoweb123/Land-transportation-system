<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'=>'required',
            'email' => 'required|email|unique:users,email,'.$this->id.',id',
            'mobile' => 'required|unique:users,mobile,'.$this->id.',id',
            'password'=>'required|min:8',
            'nationalId'=>'required|unique:users,nationalId,'.$this->id.',id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'mobile.required' => 'رقم الهاتف مطلوب',
            'mobile.numeric' => 'رقم الهاتف يجب أن يكون رقما',
            'mobile.unique' => 'هذا الهاتف موجود بالفعل',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.unique' => 'هذا البريد الإلكتروني موجود بالفعل',
            'password.required' => 'كلمة السر مطلوبة',
            'password.min' => 'كلمة السر يجب أن تتكون من 8 أحرف علي الأقل',
            'nationalId.required' => 'الرقم القومي مطلوب',
            'nationalId.unique' => 'هذا الرقم القومي موجود بالفعل',
        ];
    }
}
