<?php

namespace App\Http\Requests\MarkAsAdopted;

use Illuminate\Foundation\Http\FormRequest;

class MarkAsAdoptedRequest extends FormRequest
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
            'adopter_id' => ['required_without_all:adopter_name,adopter_contact'],
            'adopter_name' => ['required_without:adopter_id'],
            'adopter_contact' => ['required_without:adopter_id'],
        ];
    }

    public function messages()
    {
        return [
            'adopter_id.required_without_all' => 'The adopter field is required when adopter name or adopter contact is not provided.',
            'adopter_name.required_without' => 'The adopter name field is required when you select the others option.',
            'adopter_contact.required_without' => 'The adopter contact field is required when you select the others option.',
            'adopter_contact.digits' => 'The adopter contact must be 11 digits.',
        ];
    }

   
}