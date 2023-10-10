<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MyEmployeeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'oracle_id'=>'required',
            'office_id'=>'required',
            'collectionPoint_id'=>'required',
            'employeeJob_id'=>'required',
            'department_id'=>'required',
            'address'=>'required',
            'gender'=>'required',
            'phone'=>'required',
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'oracle_id.required'=>'كود الموظف مطلوب',
          'office_id.required'=>'المكتب التابع له مطلوب',
          'collectionPoint_id.required'=>'نقطة الانطلاق مطلوبة',
          'employeeJob_id.required'=>'الوظيفة مطلوبة',
          'department_id.required'=>'القسم مطلوب',
          'address.required'=>'العنوان مطلوب',
          'gender.required'=>'النوع مطلوب',
          'name.required'=>'الاسم مطلوب',
          'phone.required'=>'الهاتف مطلوب',
          'email.required'=>'البريد الالكتروني مطلوب',
          'password.required'=>'كلمة المرور مطلوبة',

        ];
    }
}
