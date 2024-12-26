<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        return match ($this->method()) {
            'POST' => [
                'first_name' => ['required'],
                'middle_name' => ['sometimes'],
                'last_name' => ['required'],
                'sex' => ['required'],
                'birth_date' => ['required'],
                'address' => ['required'],
                //'barangay_id' => ['required'],
                'contact' => ['required'],
                'email' => ['required', 'email', 'unique:users,email'],
            ],
            'PUT' => [
                'first_name' => ['required'],
                'middle_name' => ['sometimes'],
                'last_name' => ['required'],
                'sex' => ['required'],
                'birth_date' => ['required'],
                'address' => ['required'],
                //'barangay_id' => ['required'],
                'contact' => ['required'],
                'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('users')->ignore($this->admin)],
            ]
        };
    }

    public function messages()
    {
        return [
            'email.unique' => 'Email address has already been taken',
            //'barangay_id.required' => 'The barangay field is required',
        ];
    }
}