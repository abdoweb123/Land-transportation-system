<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
        'code'=>'required',
        'amount'=>'required|numeric',
        'max_amount'=>'numeric',
        'percent'=>'required',
        'startDate'=>'required',
        'endDate'=>'required',
        'max_users'=>'required',
        'max_per_user'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required'=>'الكود مطلوب',
            'amount.required'=>'الخصم مطلوب',
            'amount.numeric'=>'الخصم يجب أن يكون رقما',
            'max_amount.numeric'=>'أكبر قيمة للخصم يجب أن يكون رقما',
            'percent.required'=>'النسبة مطلوب',
            'startDate.required'=>'تاريخ البداية مطلوب',
            'endDate.required'=>'تاريخ النهاية مطلوب',
            'max_users.required'=>'العدد الكلي للمستخدمين مطلوب',
            'max_per_user.required'=>'العدد الأقصى لكل مستخدم مطلوب',
        ];
    }
}
