<?php

namespace App\Http\Resources\Adoption;

use Illuminate\Http\Resources\Json\JsonResource;

class AdoptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, 
            'category' => $this->category->name,
            'seller' => $this->user->full_name,
            'pet_name' => $this->pet_name,
            'sex' => $this->sex,
            'birth_date' => $this->birth_date,
            'breed' => $this->breed->name,
            'type' => $this->type,
            'color' => $this->color,
            'avatar' => $this->avatar_profile,
            'proof_of_ownership' => $this->proof_of_ownership,
            'is_adopted' => $this->is_adopted,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}