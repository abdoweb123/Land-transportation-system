<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestStation extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name_ar'=>'required',
            'name_en'=>'required',
            'city_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'name_ar.required'=>trans('stations_trans.station_name_ar_validation'),
          'name_en.required'=>trans('stations_trans.station_name_en_validation'),
          'city_id.required'=>trans('stations_trans.city_id_validation'),
        ];
    }
}
