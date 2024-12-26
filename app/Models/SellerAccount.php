<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SellerAccount extends Model implements HasMedia
{
    use HasFactory, BelongsToUser, InteractsWithMedia;

    public const PENDING = 0;
    public const APPROVED = 1;
    public const DECLINED = 2;

    protected $fillable = [
        'user_id',
        'business_name',
        'contact',
        'email',
        'address',
        'status',
        'remark',
        // 'password',
        // 'is_activated',
    ];

    // ============================== Accessor & Mutator ==========================================

    public function getProofOfOwnershipAttribute()
    {
        return $this->getFirstMedia('proof_of_ownership')?->getUrl('card');
    }

    // ============================== Custom Method ==========================================

    // media convertion
    public function registerMediaCollections(): void
    {
        $this->addMediaConversion('card')
            ->width(650)
            ->nonQueued();
    }

    // ============================== Scope ==========================================
    
    public function scopePending()
    {
        return $this->where('status', self::PENDING);
    }
}