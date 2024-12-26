<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
                'department_id' => ['required'],
                'name' => ['required', 'unique:courses,name'],
            ],
            'PUT' => [
                'department_id' => ['required'],
                'name' => ['required', \Illuminate\Validation\Rule::unique('courses')->ignore($this->course)],
            ],
        };
    }

    public function messages()
    {
        return [
            'name.unique' => 'Course has already been exist'
        ];
    }
}
