<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow anyone to make this request
    }

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'nric' => 'required',
            'phone_num' => 'required|string|max:11',
            'email' => 'required|email',
        ];

        if ($this->pay_for == 'MPM_PRINT') {
            $rules['address'] = 'required';
            $rules['postcode'] = 'required|integer|max:99999';
            $rules['city'] = 'required|min:3';
            $rules['state'] = 'required|max:5';
            $rules['courier'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'address.required' => 'The address field is required.',
            'postcode.required' => 'The postcode field is required.',
            'city.required' => 'The city field is required.',
            'state.required' => 'The state field is required.',
            'courier.required' => 'Courier need to pick one.',
        ];
    }
}
