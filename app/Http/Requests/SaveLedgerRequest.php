<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveLedgerRequest extends FormRequest
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
            'date' => 'required',
            'transaction' => 'required',
            'agency_name' => 'required',
            'booking_id' => 'required',
            'airline_id' => 'required',
            'pnr' => 'required',
            'to' => 'required',
            'from' => 'required',
            'arr_date' => 'required',
            'dep_date' => 'required',
        ];
    }
}
