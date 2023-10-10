<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PrintTablohRequest extends FormRequest
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
            'driver_id' => 'required',
            'bus_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'driver_id.required' => 'اسم السائق مطلوب',
            'bus_id.required' => 'كودالسيارة مطلوب',
        ];
    }


}
