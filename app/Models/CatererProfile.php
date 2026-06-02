<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatererProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'contact_number',
        'location',
        'specialty',
        'min_budget',
        'max_budget',
        'profile_picture',
        'business_permit',
        'sanitary_permit',
        'government_id',
        'status',
        'gcash_number',    
        'gcash_qr_path',
    ];

    protected $casts = [
        'min_budget' => 'decimal:2',
        'max_budget' => 'decimal:2',
    ];

    // ═══════════════════════════════════════════
    //  RELATIONSHIPS
    // ═══════════════════════════════════════════

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    // ═══════════════════════════════════════════
    //  HELPERS / ACCESSORS
    // ═══════════════════════════════════════════

    /**
     * BATCH D: Get average rating.
     * 
     * Priority order:
     * 1. If withAvg('reviews', 'rating') was used in the query, use that (most efficient)
     * 2. Otherwise, compute from loaded reviews collection
     * 3. Otherwise, query the database directly
     * 
     * This ensures the rating is ALWAYS accurate regardless of how the model was loaded.
     */
    public function getAverageRatingAttribute(): float
    {
        // If withAvg was used (e.g. in ViewCatererController), this attribute exists
        if (isset($this->attributes['reviews_avg_rating']) && $this->attributes['reviews_avg_rating'] !== null) {
            return round((float) $this->attributes['reviews_avg_rating'], 1);
        }

        // If reviews are already loaded (eager loaded), compute from collection
        if ($this->relationLoaded('reviews') && $this->reviews->count() > 0) {
            return round((float) $this->reviews->avg('rating'), 1);
        }

        // Last resort: query the database
        $avg = $this->reviews()->avg('rating');
        return round((float) ($avg ?? 0), 1);
    }

    /**
     * BATCH D: Get total review count.
     */
    public function getReviewCountAttribute(): int
    {
        if (isset($this->attributes['reviews_count'])) {
            return (int) $this->attributes['reviews_count'];
        }

        if ($this->relationLoaded('reviews')) {
            return $this->reviews->count();
        }

        return $this->reviews()->count();
    }

    /**
     * BATCH D: Get rating distribution (how many 1s, 2s, 3s, 4s, 5s).
     */
    public function getRatingDistributionAttribute(): array
    {
        $reviews = $this->relationLoaded('reviews') ? $this->reviews : $this->reviews()->get();
        $dist = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        foreach ($reviews as $r) {
            $rating = (int) $r->rating;
            if (isset($dist[$rating])) {
                $dist[$rating]++;
            }
        }
        return $dist;
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function getFormattedMinBudgetAttribute(): string
    {
        return '₱' . number_format($this->min_budget, 2);
    }

    public function getFormattedMaxBudgetAttribute(): string
    {
        return '₱' . number_format($this->max_budget, 2);
    }

    public function getFormattedPriceRangeAttribute(): string
    {
        return '₱' . number_format($this->min_budget, 2)
             . ' – ₱' . number_format($this->max_budget, 2);
    }

    /**
     * Get inclusions as array (for packages display in dashboard).
     */
    public function getInclusionsArrayAttribute(): array
    {
        if (!$this->inclusions) return [];
        return array_filter(array_map('trim', explode(',', $this->inclusions)));
    }
}