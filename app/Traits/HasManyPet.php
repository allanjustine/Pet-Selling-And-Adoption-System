<?php 

namespace App\Traits;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyPet {

    /**
     * this model has many pets
     *
     * @return BelongsTo
     */
    public function pets():HasMany
    {
        return $this->hasMany(Pet::class);
    }
}