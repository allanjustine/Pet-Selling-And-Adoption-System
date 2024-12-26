<?php

namespace App\Http\Requests\Adoption;

use Illuminate\Foundation\Http\FormRequest;

class SellerAdoptionRequest extends FormRequest
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
                'category_id' => ['required'],
                'breed_id' => ['sometimes'],
                'pet_name' => ['required'],
                'sex' => ['required'],
                'birth_date' => ['required'],
                'color' => ['required'],
                'type' => ['required'],
                'reason' => ['required'],
                'avatar' => ['required'],
                'featured_photos' => ['required'],
                'proof_of_ownership' => ['required'],
            ],
            'PUT' => [
                'category_id' => ['required'],
                'breed_id' => ['sometimes'],
                'pet_name' => ['required'],
                'sex' => ['required'],
                'birth_date' => ['required'],
                'color' => ['required'],
                'type' => ['required'],
                'reason' => ['required'],
                'avatar' => ['sometimes'],
                'featured_photos' => ['sometimes'],
                'proof_of_ownership' => ['sometimes'],
            ]
        };
    }

    public function messages()
    {
        return [
            'category_id.required' => 'The category field is required',
            'breed_id.required' => 'The breed field is required',
            'name.required' => 'The pet name field is required',
            'avatar.required' => 'The pet must have an avatar profile', 
            'featured_photos.required' => 'Please upload atleast one featured photo', 
            'proof_of_ownership.required' => 'Please upload a proof of ownership',
        ];
    }
}