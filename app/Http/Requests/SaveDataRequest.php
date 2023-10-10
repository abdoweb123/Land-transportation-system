<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveDataRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'paid_cash'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'paid_cash.required'=>'المبلغ المدفوع مطلوب',
        ];
    }
}
