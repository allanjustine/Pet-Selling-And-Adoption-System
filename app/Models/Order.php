<?php

namespace App\Models;

use App\Traits\BelongsToPaymentMethod;
use App\Traits\BelongsToPet;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
{
    use 
    HasFactory,
    BelongsToUser,
    BelongsToPet,
    BelongsToPaymentMethod,
    InteractsWithMedia;

    public const PENDING = 0;
    public const APPROVED = 1;
    public const DECLINED = 2;
    public const TO_BE_DELIVERED = 3;
    public const DELIVERED = 4;
    public const CANCELED = 5;
    
    protected $fillable = [
        'user_id',
        'pet_id',
        'contact',
        'payment_method_id',
        'transaction_no',
        'reference_no',
        'note',
        'status',
        'remark',
        'payment_type',
        'has_been_received_by_buyer',
        'has_been_delivered_by_seller'
    ];

    // ============================== Relationship ==========================================

    public function additional_payment():HasOne
    {
        return $this->hasOne(AdditionalPayment::class);
    }
  

    // ============================== Accessor & Mutator ==========================================

    public function getPaymentReceiptAttribute()
    {
        return optional($this->getFirstMedia('payment_receipts'))->getUrl('card');
    }

    public function getProofOfDeliveryAttribute()
    {
        return optional($this->getFirstMedia('proof_of_deliveries'))->getUrl('card');
    }

    // ========================== Custom Methods ======================================================

    /**
    * media conversion
    */
    public function registerMediaCollections(): void
    {
        $this->addMediaConversion('card')
        ->width(450)
        ->keepOriginalImageFormat()
        ->nonQueued();
    }

    // ========================== Scope ======================================================

    public function scopePending($query)
    {
        return $query->where('status', self::PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::APPROVED);
    }
}