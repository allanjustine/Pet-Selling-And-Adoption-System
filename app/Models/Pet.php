<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use App\Traits\HasAvatar;
use App\Traits\HasManyComment;
use App\Traits\HasManyLike;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model implements HasMedia
{
    use HasFactory, 
    HasManyLike,
    HasManyComment,
    BelongsToUser,
    HasAvatar,
    InteractsWithMedia;

    public const PENDING = 0;
    public const APPROVED = 1;
    public const DECLINED = 2;

    protected $fillable = [
        'user_id',
        'category_id',
        'breed_id',
        'name',
        'sex',
        'birth_date',
        'color',
        'type',
        'vaccine_taken',
        'price',
        'notes',
        'is_available',
        'status',
    ];

    // ==============================Relationship==================================================
    
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function breed():BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function avatar():HasOne
    {
        return $this->hasOne(Media::class, 'model_id', 'id');
    }

    public function order():HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function pending_order():HasOne
    {
        return $this->hasOne(Order::class)->whereIn('status', [Order::PENDING, Order::APPROVED, Order::TO_BE_DELIVERED, Order::DELIVERED]);
    }

    // ============================== Accessor & Mutator ==========================================

    public function getProofOfOwnershipAttribute()
    {
        return $this->getFirstMedia('proof_of_ownership')?->getUrl('card');
    }

    public function getVaccinationHistoryAttribute()
    {
        return $this->getFirstMedia('vaccination_history')?->getUrl('card');
    }

    public function getDewormingHistoryAttribute()
    {
        return $this->getFirstMedia('deworming_history')?->getUrl('card');
    }

    // public function getVaccinationHistoriesAttribute()
    // {
    //     return $this->getMedia('vaccination_histories')?->getUrl('card');
    // }

    // ============================== Custom Method ==========================================

     // media convertion
     public function registerMediaCollections(): void
     {
         $this->addMediaConversion('thumbnail')
             ->width(300)
             ->nonQueued();
 
         $this->addMediaConversion('avatar')
             ->width(600)
             ->nonQueued();

         $this->addMediaConversion('card')
             ->width(650)
             ->nonQueued();
     }

     public function isApproved()
     {
        return $this->where('status', self::APPROVED) ? true : false;
     }


    // ========================== Scope ======================================================

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeSold($query)
    {
        return $query->where('is_available', false);
    }
}