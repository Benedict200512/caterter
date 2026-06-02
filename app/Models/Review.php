<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * FIX #12: Added caterer_reply and caterer_reply_at for right-of-reply feature.
     */
    protected $fillable = [
        'user_id',
        'caterer_profile_id',
        'booking_id',
        'rating',
        'comment',
        'caterer_reply',
        'caterer_reply_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'rating'           => 'integer',
        'caterer_reply_at' => 'datetime',
    ];

    /**
     * Relationship: The user (customer) who wrote the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: The caterer being reviewed.
     */
    public function catererProfile(): BelongsTo
    {
        return $this->belongsTo(CatererProfile::class);
    }

    /**
     * Relationship: The specific booking this review is for.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Check if the caterer has already replied.
     */
    public function hasReply(): bool
    {
        return !empty($this->caterer_reply);
    }
}