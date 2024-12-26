<?php

namespace App\Models;

use App\Models\Role;
use App\Traits\HasAvatar;
use App\Traits\HasManyComment;
use App\Traits\HasManyLike;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use HasFactory,
    HasManyLike,
    HasManyComment, 
    Notifiable,
    HasAvatar,
    InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'address',
        'barangay_id',
        'contact',
        'email',
        'password',
        'verification_token',
        'email_verified_at',
        'is_activated',
        //'current_role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   
    // ==============================Relationship==================================================

    public function avatar():HasOne
    {
        return $this->hasOne(Media::class, 'model_id', 'id');
    }

    public function role():BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function barangay():BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function additional_payments():HasMany
    {
        return $this->hasMany(AdditionalPayment::class);   
    }

    public function ratings():HasMany
    {
        return $this->hasMany(Rating::class, 'receiver_id', 'id');
    }
    // public function current_role():BelongsTo
    // {
    //     return $this->belongsTo(Role::class);
    // }

    public function seller_account():HasOne
    {
        return $this->hasOne(SellerAccount::class)->where('status', SellerAccount::APPROVED);
    }


    public function pets():HasMany
    {
        return $this->hasMany(Pet::class);
    }
  
    public function adoptions():HasMany
    {
        return $this->hasMany(Adoption::class);
    }
  
    // ============================== Accessor & Mutator ==========================================

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }


    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAvgRatingsAttribute()
    {
        return $this->ratings()->avg('rating');
    }

    // ========================== Custom Methods ======================================================

     // media convertion
    public function registerMediaCollections(): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(300)
            ->nonQueued();

        $this->addMediaConversion('avatar')
            ->width(600)
            ->nonQueued();
    }

    public function hasRole($role)
    {
       return $this->role()->where('name', $role)->first() ? true : false;
    }

    // public function hasCurrentRole($role)
    // {
    //    return $this->current_role()->where('name', $role)->first() ? true : false;
    // }

    public function hasSellerAccount()
    {
        return $this->seller_account()->exists() ? true : false;
    }

    // ========================== Scope ======================================================

    public function scopeByRole($query, $role)
    {
        return is_array($role) ? $query->whereIn('role_id', $role) : $query->whereRelation('role', 'name', $role);
    }

    public function scopeActive($query)
    {
        return $query->where('is_activated', true);
    }
    
    public function scopeInactive($query)
    {
        return $query->where('is_activated', false);
    }
}