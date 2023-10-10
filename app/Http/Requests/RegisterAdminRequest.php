<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAdminRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', /*'confirmed'*/],
//            'superVisor_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
          'name.required'=>'اسم المستخدم مطلوب',
          'email.required'=>' البريد الإلكتروني مطلوب',
          'email.email'=>' البريد الإلكتروني يجب أن يكون صالحا',
          'email.unique'=>'هذا البريد الإلكتروني موجود بالفعل',
          'password.required'=>'كلمة المرور مطلوبة',
          'password.min'=>'كلمة المرور يجب أن تحتوي على 8 حروف على الأقل',
//          'password.confirmed'=>'لم يتم تأكيد كلمة المرور',
//          'superVisor_id.required' => 'المشرف العام مطلوب',
        ];
    }
}
