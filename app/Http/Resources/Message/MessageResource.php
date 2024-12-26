<?php

namespace App\Http\Resources\Message;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'sender_id' => $this->sender_id,
            'sender' => $this->sender->full_name, 
            'sender_avatar' => $this->sender->avatar_profile,
            'recipient_id' => $this->recipient_id,
            'recipient' => $this->recipient->full_name, 
            'recipient_avatar' => $this->recipient->avatar_profile,
            'message' => $this->message,
            'images' => $this->getMedia('message_images')->map(fn($image) => $image->getFullUrl('card')),
            'created_at' => formatDate($this->created_at,'dateTime'),
        ];
    }
}