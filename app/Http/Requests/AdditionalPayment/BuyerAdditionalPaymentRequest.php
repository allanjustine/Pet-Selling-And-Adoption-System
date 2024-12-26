<?php

namespace App\Http\Requests\AdditionalPayment;

use Illuminate\Foundation\Http\FormRequest;

class BuyerAdditionalPaymentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'payment_method_id' =>  ['required'],
            'reference_no' => ['required'],
            'image' =>  ['required'],
        ];
    }

    public function messages()
    {
        return [
            'payment_method_id.required' => 'The payment method field is required',
            'image.required' => 'Please upload a screenshot of your additional payment receipt from your selected payment method',
        ];
    }
}