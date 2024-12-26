<?php 

namespace App\Traits;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToPet {

    /**
     * this model belongs to pet
     *
     * @return BelongsTo
     */
    public function pet():BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}