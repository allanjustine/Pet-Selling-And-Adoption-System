<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
                'campus_id' => ['required'],
                'name' => ['required', 'unique:departments,name'],
            ],
            'PUT' => [
                'campus_id' => ['required'],
                'name' => ['required', \Illuminate\Validation\Rule::unique('departments')->ignore($this->department)],
            ],
        };
    }

    public function messages()
    {
        return [
            'name.unique' => 'Department has already been exist'
        ];
    }
}
