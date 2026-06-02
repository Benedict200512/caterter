<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id', 
        'sender_id', 
        'message', 
        'is_read'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Relationship: The user who sent this message.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relationship: The booking this message belongs to.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Scope: Filter only unread messages.
     * Usage: Message::unread()->get();
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Helper: Determine if the message was sent by the Customer of the booking.
     */
    public function isSentByCustomer(): bool
    {
        return (int) $this->sender_id === (int) $this->booking->user_id;
    }

    /**
     * Helper: Determine if the message was sent by the Caterer of the booking.
     */
    public function isSentByCaterer(): bool
    {
        return (int) $this->sender_id === (int) $this->booking->catererProfile->user_id;
    }
}