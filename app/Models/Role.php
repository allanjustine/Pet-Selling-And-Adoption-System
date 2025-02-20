<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    public const ADMIN = 1;
    public const SELLER = 2;
    public const BUYER = 3;

    public function users():HasMany
    {
        return $this->hasMany(User::class);
    }
}