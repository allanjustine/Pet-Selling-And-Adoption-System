<?php

namespace App\Models;

use App\Traits\BelongsToPet;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use 
    HasFactory,
    BelongsToUser,
    BelongsToPet;

    protected $fillable = ['user_id', 'pet_id'];

}