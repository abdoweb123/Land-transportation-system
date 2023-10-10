<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GetGoTripsRequest extends FormRequest
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
            'from_station_go' => 'required',
            'to_station_go' => 'required',
            'from_date_go' => 'required',
            'to_date_go' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'from_station_go.required' => 'منطقة الانطلاق مطلوب',
            'to_station_go.required' => 'منطقة الوصول مطلوب',
            'from_date_go.required' => 'تاريخ البداية مطلوب',
            'to_date_go.required' => 'تاريخ النهاية مطلوب',
        ];
    }


}
