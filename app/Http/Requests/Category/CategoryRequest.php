<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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

    public function rules()
    {
        return match($this->method()) {
            'POST' => [
                'name' => ['required', 'unique:categories,name'],
                'has_vaccination' => ['required', 'boolean'],
                'has_deworming' => ['required', 'boolean'],
            ],
            'PUT' => [
                'name' => ['required', \Illuminate\Validation\Rule::unique('categories')->ignore($this->category)],
                'has_vaccination' => ['required', 'boolean'],
                'has_deworming' => ['required', 'boolean'],
            ],
        };
    }

    public function messages()
    {
        return [
            'name.required' => 'The category field is required',
            'name.unique' => 'The category has already been exist'
        ];
    }
}