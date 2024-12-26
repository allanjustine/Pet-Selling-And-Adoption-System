<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends FormRequest
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
            'status' => ['required'],
            'remark' => ['required_if:status,2']
        ];
    }

    public function messages()
    {
        return [
            'remark.required_if' => 'The remark field is required when you decline a request.',
        ];
    }
}