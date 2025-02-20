<?php

namespace App\Http\Requests\MarkAsDelivered;

use Illuminate\Foundation\Http\FormRequest;

class MarkAsDeliveredRequest extends FormRequest
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
            'image' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'Please upload a picture as proof of delivery',
        ];
    }
}