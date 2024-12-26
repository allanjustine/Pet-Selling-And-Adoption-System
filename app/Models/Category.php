<?php

namespace App\Models;

use App\Traits\HasManyPet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory,
    HasManyPet;

    protected $fillable = ['name', 'has_vaccination', 'has_deworming'];

    // ==============================Relationship==================================================

    public function breeds():HasMany
    {
        return $this->hasMany(Breed::class);
    }
}