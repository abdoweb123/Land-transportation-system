<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class search_ticket_to_print extends FormRequest
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
            'user_phone' => 'required',
            'date_of_ticket' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_phone.required' => 'الهاتف مطلوب',
            'date_of_ticket.required' => 'تاريخ إنشاء التذكرة مطلوب',
        ];
    }


}
