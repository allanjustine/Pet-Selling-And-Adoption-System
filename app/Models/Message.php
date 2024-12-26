<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['sender_id', 'recipient_id', 'message'];

    public $casts = [
        'message' => 'encrypted',
    ];

     // ========================== Relationships ======================================================

    public function sender():BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function recipient():BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id', 'id');
    }

     // ========================== Custom Methods ======================================================

     public function registerMediaCollections(): void
     {
         $this->addMediaConversion('card')
         ->width(600)
         ->nonQueued();
     }
}