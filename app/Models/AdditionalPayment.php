<?php

namespace App\Models;

use App\Traits\BelongsToOrder;
use App\Traits\BelongsToUser;
use App\Traits\BelongsToPaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;

class AdditionalPayment extends Model implements HasMedia
{
    use 
    HasFactory,
    BelongsToUser,
    BelongsToOrder,
    BelongsToPaymentMethod,
    InteractsWithMedia;

    public const PENDING = 0;
    public const APPROVED = 1;
    public const DECLINED = 2;

    protected $fillable = [
        'user_id',
        'order_id',
        'payment_method_id',
        'transaction_no',
        'reference_no',
        'status',
        'remark',
    ];

    // ============================== Relationship ==========================================

    // public function order():BelongsTo
    // {
    //     return $this->belongsTo(Order::class);
    // }

    // ============================== Accessor & Mutator ==========================================

    public function getPaymentReceiptAttribute()
    {
        return optional($this->getFirstMedia('payment_receipts'))->getUrl('card');
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
}