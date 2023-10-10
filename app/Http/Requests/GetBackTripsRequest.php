<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GetBackTripsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }



    public function rules()
    {
        return [
            'from_station_back' => 'required',
            'to_station_back' => 'required',
            'from_date_back' => 'required',
            'to_date_back' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'from_station_back.required' => 'منطقة الانطلاق مطلوب',
            'to_station_back.required' => 'منطقة الوصول مطلوب',
            'from_date_back.required' => 'تاريخ البداية مطلوب',
            'to_date_back.required' => 'تاريخ النهاية مطلوب',
        ];
    }


}
