<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'transaction_no' => $this->transaction_no,
            'reference_no' => $this->reference_no,
            'payment_type' => $this->payment_type,
            'pet' => $this->pet->name,
            'breed' => $this->pet->breed->name,
            'buyer' => $this->user->full_name,
            'status' => $this->status,
            'updated_at' => $this->updated_at?->toDateString() ?? $this->created_at->toDateString(),
        ];
    }
}