<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
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
                'name' => ['required', 'unique:places,name'],
                'history' => ['sometimes'],
                'latitude' => ['required'],
                'longitude' => ['required']
            ],
            'PUT' => [
                'name' => ['required', \Illuminate\Validation\Rule::unique('places')->ignore($this->place)],
                'history' => ['sometimes'],
                'latitude' => ['required'],
                'longitude' => ['required']
            ],
        };
    }

    public function messages()
    {
        return [
            'name.unique' => 'Place has already been exist'
        ];
    }
}
