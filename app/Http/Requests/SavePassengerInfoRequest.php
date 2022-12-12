<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePassengerInfoRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'title' => 'required',
            'passenger_name' => 'required',
            'ticket' => 'required',
            'payment_type' => 'required',
            'p_value' => 'required',
            'v_value' => 'required',
            'remarks' => 'required',

        ];
    }
}
