<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployee extends FormRequest
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
            'code' => 'required',
            'department_id' => 'required',
            'employeeJob_id' => 'required',
            'employeeSituation_id' => 'required',
            'birthdate' => 'required',
            'appointDate' => 'required',
            'degree' => 'required',
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
            'code.required' => 'كود المستخدم مطلوب',
            'department_id.required' => 'اسم القسم مطلوب',
            'employeeJob_id.required' => 'اسم الوظيفة مطلوب',
            'employeeSituation_id.required' => 'موقف الموظف مطلوب',
            'birthdate.required' => 'تاريخ الميلاد مطلوب',
            'appointDate.required' => 'تاريخ التعيين مطلوب',
            'degree.required' => 'درجة المستخدم مطلوب',
        ];
    }

}
