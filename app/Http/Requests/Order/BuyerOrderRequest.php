<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class BuyerOrderRequest extends FormRequest
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
            'pet_id' => ['required'],
            'contact' => ['required', 'digits:11'],
            'payment_method_id' =>  ['required'],
            'reference_no' => ['required'],
            'image' =>  ['required'],
            'note' => ['sometimes'],
        ];
    }

    public function messages()
    {
        return [
            'payment_method_id.required' => 'The payment method field is required',
            'image.required' => 'Please upload a screenshot of your payment receipt from your selected payment method',
        ];
    }
}