<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
            'avatar' => $this->user->avatar_profile,
            'owner' => $this->user->full_name,
            'business_name' => $this->business_name,
            'contact' => $this->contact,
            'email' => $this->email,
            'proof_of_ownership' => $this->proof_of_ownership,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateString()
        ];
    }
}