<?php 

namespace App\Traits;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOrder {

    /**
     * this model belongs to Order
     *
     * @return BelongsTo
     */
    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}