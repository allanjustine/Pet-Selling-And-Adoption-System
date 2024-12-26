<?php

namespace App\Models;

use App\Traits\BelongsToOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use 
    BelongsToOrder,
    HasFactory;

    protected $fillable = [
        'order_id',
        'sender_id', 
        'receiver_id', 
        'rating', 
        'comment'
    ];

    // ========================== Relationships ======================================================

    public function sender():BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver():BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

}