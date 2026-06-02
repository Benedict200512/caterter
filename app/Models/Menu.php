<?php

 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Menu extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'caterer_profile_id',
        'name',
        'category',
        'description',
        'price',
        'is_available',
    ];
 
    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
    ];
 
    public function catererProfile()
    {
        return $this->belongsTo(CatererProfile::class);
    }
 
    // Formatted price helper
    public function getFormattedPriceAttribute(): string
    {
        return '₱' . number_format($this->price, 2);
    }
}
 