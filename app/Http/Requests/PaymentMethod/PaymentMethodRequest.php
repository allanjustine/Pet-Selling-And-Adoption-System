<?php

namespace App\Http\Requests\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
        return match ($this->method()) {
            'POST' => [
                'type' => ['required', \Illuminate\Validation\Rule::unique('payment_methods','type')],
                'account_name' => ['required'],
                'account_no' => ['required'],
            ],
            'PUT' => [
                'type' => ['sometimes',  \Illuminate\Validation\Rule::unique('payment_methods', 'type')->ignore($this->payment_method)],
                'account_name' => ['sometimes'],
                'account_no' => ['sometimes'],
            ]
        };
    }

    public function messages()
    {
        return [
            'type.unique' => 'Payment method has already been exist'
        ];
    }
}