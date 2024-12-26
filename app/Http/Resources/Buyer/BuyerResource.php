<?php

namespace App\Http\Resources\Buyer;

use Illuminate\Http\Resources\Json\JsonResource;

class BuyerResource extends JsonResource
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
            'avatar' => $this->avatar_profile,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'sex' => $this->sex,
            'birth_date' => $this->birth_date,
            'address' => $this->address,
            // 'barangay' => $this->barangay->name,
            'contact' => $this->contact,
            'email' => $this->email,
            'created_at' => $this->created_at->toDateString()
        ];
    }
}