<?php

namespace App\Models;

use App\Traits\HasManyPet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Breed extends Model
{
    use HasFactory, 
    HasManyPet;

    protected $fillable = ['category_id','name'];


    // ==============================Relationship==================================================

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}