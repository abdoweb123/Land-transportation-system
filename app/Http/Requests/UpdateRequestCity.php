<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestCity extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name_ar'=>'required',
            'name_en'=>'required'
        ];
    }

    public function messages()
    {
        return [
          'name_ar.required'=>trans('cities_trans.city_name_ar_validation'),
          'name_en.required'=>trans('cities_trans.city_name_en_validation')
        ];
    }
}
