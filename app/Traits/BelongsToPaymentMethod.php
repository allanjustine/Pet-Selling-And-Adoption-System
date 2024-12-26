<?php 

namespace App\Traits;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToPaymentMethod {

    /**
     * this model belongs to pet
     *
     * @return BelongsTo
     */
    public function payment_method():BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}