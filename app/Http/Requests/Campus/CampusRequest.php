<?php

namespace App\Http\Requests\Campus;

use Illuminate\Foundation\Http\FormRequest;

class CampusRequest extends FormRequest
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
                'name' => ['required', 'unique:campuses,name'],
                'latitude' => ['required'],
                'longitude' => ['required']
            ],
            'PUT' => [
                'name' => ['required', \Illuminate\Validation\Rule::unique('campuses')->ignore($this->campus)],
                'latitude' => ['required'],
                'longitude' => ['required']
            ],
        };
    }

    public function messages()
    {
        return [
            'name.unique' => 'Campus has already been exist'
        ];
    }
}
