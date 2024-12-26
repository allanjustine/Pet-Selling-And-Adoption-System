<?php

namespace App\Http\Requests\Faculty;

use Illuminate\Foundation\Http\FormRequest;

class FacultyRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'campus_id' => ['required'],
            'department_id' => ['required'],
            'name' => ['required'],
            'honorifics' => ['sometimes'],
        ];
    }

    public function messages()
    {
        return [
            'campus_id' => 'Campus field is required',
            'department_id' => 'Department field is required',
        ];
    }
}
