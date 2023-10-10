<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'time_to_edit'=>'required',
            'time_to_edit_without_fee'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'time_to_edit.required'=>'الوقت المسموح فيه التعديل مطلوب',
          'time_to_edit_without_fee.required'=>'الوقت المسموح فيه التعديل بدون غرامة مطلوب',
        ];
    }


}
