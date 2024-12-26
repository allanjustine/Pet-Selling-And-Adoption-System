<?php

namespace App\Http\Resources\Pet;

use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
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
            'name' => $this->name,
            'sex' => $this->sex,
            'birth_date' => $this->birth_date,
            'breed' => $this->breed->name,
            'type' => $this->type,
            'color' => $this->color,
            'price' => number_format($this->price, 2),
            'avatar' => $this->avatar_profile,
            'proof_of_ownership' => $this->proof_of_ownership,
            'is_available' => $this->is_available,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}