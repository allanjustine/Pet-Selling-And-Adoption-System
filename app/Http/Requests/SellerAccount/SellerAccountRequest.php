<?php

namespace App\Http\Requests\SellerAccount;

use Illuminate\Foundation\Http\FormRequest;

class SellerAccountRequest extends FormRequest
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
            'business_name' => ['required'],
            'contact' => ['required', 'digits:11'],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'proof_of_ownership' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'proof_of_ownership.required' => 'Please upload a proof of ownership',
        ];
    }
}