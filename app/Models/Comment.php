<?php

namespace App\Models;

use App\Traits\BelongsToPet;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use 
    HasFactory,
    BelongsToUser,
    BelongsToPet;

    protected $fillable = ['user_id', 'pet_id', 'comment'];
}