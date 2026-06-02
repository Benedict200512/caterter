<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | BOOKING STATUS LIFECYCLE (Batch B + C merged)
    |--------------------------------------------------------------------------
    |
    | pending           → Customer submitted inquiry
    | confirmed         → Caterer approved, waiting for customer to pay
    | awaiting_payment  → Customer uploaded receipt, caterer reviewing
    | paid              → Caterer verified downpayment
    | completed         → Event done, caterer marked complete
    | rejected          → Caterer declined the inquiry
    | cancelled         → Customer cancelled OR auto-cancelled (deadline)
    |
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'caterer_profile_id',
        'event_date',
        'event_time',
        'event_type',
        'event_location',
        'dietary_requirements',
        'pax',
        'status',
        'notes',
        'selected_package_id',
        'selected_package_name',
        'selected_menu_ids',
        'estimated_total',
        'rejection_reason',
        'downpayment_amount',
        'downpayment_deadline',
        'downpayment_paid',
        'payment_methods',
        'special_notes',
        'payment_receipt_path',
        'payment_method_used',
        'payment_status',
        'payment_verified_at',
        'payment_rejection_reason',
        'auto_cancelled_at',
        'cancellation_type',
    ];

    protected $casts = [
        'event_date'           => 'date',
        'event_time'           => 'datetime:H:i',
        'pax'                  => 'integer',
        'selected_menu_ids'    => 'array',
        'estimated_total'      => 'float',
        'downpayment_amount'   => 'float',
        'downpayment_deadline' => 'date',
        'downpayment_paid'     => 'boolean',
        'payment_methods'      => 'array',
        'payment_verified_at'  => 'datetime',
        'auto_cancelled_at'    => 'datetime',
    ];

    // ═══════════════════════════════════════════
    //  RELATIONSHIPS
    // ═══════════════════════════════════════════

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function catererProfile(): BelongsTo
    {
        return $this->belongsTo(CatererProfile::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'selected_package_id');
    }

    // ═══════════════════════════════════════════
    //  STATUS CHECKS
    // ═══════════════════════════════════════════

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isAwaitingPayment(): bool
    {
        return $this->status === 'awaiting_payment';
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'awaiting_payment', 'paid']);
    }

    public function isEnded(): bool
    {
        return in_array($this->status, ['completed', 'rejected', 'cancelled']);
    }

    public function needsPayment(): bool
    {
        return $this->status === 'confirmed'
            && in_array($this->payment_status, ['unpaid', 'rejected'])
            && !$this->isDeadlinePassed();
    }

    public function isPaymentPendingReview(): bool
    {
        return $this->status === 'awaiting_payment'
            && $this->payment_status === 'submitted';
    }

    public function isDeadlinePassed(): bool
    {
        if (!$this->downpayment_deadline) return false;
        return now()->startOfDay()->gt($this->downpayment_deadline);
    }

    // ═══════════════════════════════════════════
    //  ACCESSORS
    // ═══════════════════════════════════════════

    public function getTotalPriceAttribute(): float
    {
        if ($this->estimated_total && $this->estimated_total > 0) {
            return (float) $this->estimated_total;
        }
        if ($this->package && $this->pax) {
            return (float) ($this->pax * $this->package->price_per_guest);
        }
        return 0.00;
    }

    public function getFormattedTimeAttribute(): string
    {
        if (!$this->event_time) return '—';
        return \Carbon\Carbon::parse($this->event_time)->format('g:i A');
    }

    public function getEventTypeLabelAttribute(): string
    {
        $labels = [
            'wedding'     => 'Wedding Reception',
            'birthday'    => 'Birthday Celebration',
            'corporate'   => 'Corporate Event',
            'debut'       => 'Debut / Cotillion',
            'reunion'     => 'Family Reunion',
            'graduation'  => 'Graduation Party',
            'christening' => 'Christening / Baptism',
            'fiesta'      => 'Fiesta / Community Event',
            'other'       => 'Other',
        ];
        return $labels[$this->event_type] ?? ucfirst($this->event_type ?? '—');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'           => 'Pending Review',
            'confirmed'         => 'Confirmed — Awaiting Payment',
            'awaiting_payment'  => 'Payment Under Review',
            'paid'              => 'Paid — Event Secured',
            'completed'         => 'Completed',
            'rejected'          => 'Rejected',
            'cancelled'         => 'Cancelled',
            default             => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): array
    {
        return match($this->status) {
            'pending'          => ['bg' => '#fef3c7', 'text' => '#d97706', 'icon' => 'hourglass-split'],
            'confirmed'        => ['bg' => '#fff8f0', 'text' => '#FF7A00', 'icon' => 'credit-card-2-front'],
            'awaiting_payment' => ['bg' => '#dbeafe', 'text' => '#2563eb', 'icon' => 'clock-history'],
            'paid'             => ['bg' => '#d1fae5', 'text' => '#059669', 'icon' => 'patch-check-fill'],
            'completed'        => ['bg' => '#e0e7ff', 'text' => '#4f46e5', 'icon' => 'trophy-fill'],
            'rejected'         => ['bg' => '#fee2e2', 'text' => '#dc2626', 'icon' => 'x-circle-fill'],
            'cancelled'        => ['bg' => '#f3f4f6', 'text' => '#6b7280', 'icon' => 'slash-circle'],
            default            => ['bg' => '#f3f4f6', 'text' => '#6b7280', 'icon' => 'question-circle'],
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            'unpaid'    => 'Awaiting Payment',
            'submitted' => 'Receipt Submitted',
            'verified'  => 'Payment Verified',
            'rejected'  => 'Payment Rejected',
            default     => 'Unpaid',
        };
    }

    public function getPaymentStatusColorAttribute(): array
    {
        return match($this->payment_status) {
            'unpaid'    => ['bg' => '#fef3c7', 'text' => '#d97706'],
            'submitted' => ['bg' => '#dbeafe', 'text' => '#2563eb'],
            'verified'  => ['bg' => '#d1fae5', 'text' => '#059669'],
            'rejected'  => ['bg' => '#fee2e2', 'text' => '#dc2626'],
            default     => ['bg' => '#f3f4f6', 'text' => '#6b7280'],
        };
    }

    public function getDaysUntilDeadlineAttribute(): ?int
    {
        if (!$this->downpayment_deadline) return null;
        return (int) now()->startOfDay()->diffInDays($this->downpayment_deadline, false);
    }
}