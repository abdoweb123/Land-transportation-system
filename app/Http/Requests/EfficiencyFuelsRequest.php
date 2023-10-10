<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EfficiencyFuelsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'bus_id'=>'required',
            'volume'=>'required|numeric',
            'total_cost'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return [
          'bus_id.required'=>'كود الحافلة مطلوب',
          'volume.required'=>'كمية البنزين مطلوبة',
          'volume.numeric'=>'كمية البنزين يجب أن تكون رقما',
          'total_cost.required'=>'المبلغ الكلي المدفوع مطلوب',
          'total_cost.numeric'=>'المبلغ الكلي يجب أن تكون رقما',
        ];
    }
}
