<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'caterer_profile_id',
        'name',
        'description',
        'price_per_guest',
        'min_guests',
        'max_guests',
        'inclusions',
        'is_available',
    ];

    protected $casts = [
        'price_per_guest' => 'decimal:2',
        'min_guests'      => 'integer',
        'max_guests'      => 'integer',
        'is_available'    => 'boolean',
    ];

    public function catererProfile(): BelongsTo
    {
        return $this->belongsTo(CatererProfile::class);
    }

    
    public function getInclusionsArrayAttribute(): array
    {
        if (!$this->inclusions) return [];
        return array_filter(array_map('trim', explode(',', $this->inclusions)));
    }
}