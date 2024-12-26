<?php

namespace App\Http\Resources\Message;

use Illuminate\Http\Resources\Json\JsonResource;

class NewMessageResource extends JsonResource
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
            'sender' => $this->sender->full_name, 
            'avatar' => $this->sender->avatar_profile,
            'message' => $this->message,
            'images' => $this->getMedia('message_images')->map(fn($image) => $image->getFullUrl('card')),
            'created_at' => formatDate($this->created_at,'dateTime'),
        ];
    }
}