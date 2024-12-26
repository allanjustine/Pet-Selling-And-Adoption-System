<?php

namespace App\Models\All;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpImage extends Model
{
    use HasFactory;

    protected $fillable = ['filename'];
}
