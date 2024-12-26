<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use App\Traits\HasAvatar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Adoption extends Model implements HasMedia
{
    use 
    HasFactory,
    BelongsToUser, 
    HasAvatar,
    InteractsWithMedia;

    public const PENDING = 0;
    public const APPROVED = 1;
    public const DECLINED = 2;

    protected $fillable = [
        'category_id',
        'breed_id',
        'pet_name',
        'sex',
        'birth_date',
        'color',
        'type',
        'reason',
        'adopter_id',
        'adopter_name',
        'adopter_contact',
        'is_adopted',
        'status',
    ];

    // ==============================Relationship==================================================
    
    public function avatar():HasOne
    {
        return $this->hasOne(Media::class, 'model_id', 'id');
    }

    public function adopter():BelongsTo
    {
        return $this->belongsTo(User::class, 'adopter_id', 'id');
    }

    public function breed():BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
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

    // ============================== Custom Method ==========================================

    // media convertion
    public function registerMediaCollections(): void
    {
        $this->addMediaConversion('avatar')
            ->width(450)
            ->nonQueued();

        $this->addMediaConversion('card')
            ->width(650)
            ->nonQueued();
    }

    // ========================== Scope ======================================================

    public function scopeAdopted($query)
    {
        return $query->where('is_adopted', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_adopted', false);
    }

}