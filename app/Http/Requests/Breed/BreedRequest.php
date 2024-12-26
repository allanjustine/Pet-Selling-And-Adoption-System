<?php

namespace App\Http\Requests\Breed;

use Illuminate\Foundation\Http\FormRequest;

class BreedRequest extends FormRequest
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
                'category_id' => ['required'],
                'name' => ['required', 'unique:breeds,name'],
            ],
            'PUT' => [
                'category_id' => ['required'],
                'name' => ['required', \Illuminate\Validation\Rule::unique('breeds')->ignore($this->breed)],
            ],
        };
    }

    public function messages()
    {
        return [
            'category_id' => 'The category field is required',
            'name.required' => 'The breed field is required',
            'name.unique' => 'The breed has already been exist',
        ];
    }
}