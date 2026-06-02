<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'date_of_birth',
        'address',
        'phone',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth'     => 'date',
        'password'          => 'hashed',
    ];

    /**
     * Relationship: A user can have one Caterer Profile.
     */
    public function catererProfile(): HasOne
    {
        return $this->hasOne(CatererProfile::class);
    }

    /**
     * Relationship: A user (Customer) can have many Bookings.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Helper Method: Check if user is an Admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Helper Method: Check if user is a Caterer.
     */
    public function isCaterer(): bool
    {
        return $this->role === 'caterer';
    }

    /**
     * Helper Method: Get the user's age from date of birth.
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    /**
     * Helper Method: Get display name (username or name fallback).
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->username ?? $this->name;
    }
}