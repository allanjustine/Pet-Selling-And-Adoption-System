<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        return match($this->method()) {
            'POST' => [
                // 'name' => ['required', 'unique:categories,name'],
            ],
            'PUT' => [
                'is_activated' => ['required'],
                'remark' => ['required_if:is_activated,0']
            ],
        };
    }

    public function messages()
    {
        return [
            'remark.required_if' => 'The remark field is required when you deactivate an account',
        ];
    }
}