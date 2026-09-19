<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'freelancer_profile_id',
        'conversation_id',
        'order_number',
        'status',
        'subtotal',
        'platform_fee',
        'total',
        'freelancer_amount',
        'requirements',
        'delivery_days',
        'due_at',
        'paid_at',
        'completed_at',
        'cancel_reason',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'platform_fee' => 'decimal:2',
            'total' => 'decimal:2',
            'freelancer_amount' => 'decimal:2',
            'delivery_days' => 'integer',
            'due_at' => 'datetime',
            'paid_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Client pemilik order.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'client_id'
        );
    }

    /**
     * Freelancer yang mengerjakan order.
     */
    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(
            FreelancerProfile::class,
            'freelancer_profile_id'
        );
    }

    /**
     * Item-item dalam order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
            'order_id'
        );
    }

    /**
     * Payment order.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(
            Payment::class,
            'order_id'
        );
    }

    /**
     * Delivery order.
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(
            Delivery::class,
            'order_id'
        );
    }

    /**
     * Commission order.
     */
    public function commission(): HasOne
    {
        return $this->hasOne(
            Commission::class
        );
    }

    /**
     * Review order.
     */
    public function review(): HasOne
    {
        return $this->hasOne(
            Review::class
        );
    }

    /**
     * Conversation order.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(
            Conversation::class
        );
    }

    /**
     * Semua riwayat pengajuan cancellation.
     */
    public function cancellationRequests(): HasMany
    {
        return $this->hasMany(
            CancellationRequest::class,
            'order_id'
        );
    }

    /**
     * Pengajuan cancellation terbaru.
     */
    public function latestCancellationRequest(): HasOne
    {
        return $this->hasOne(
            CancellationRequest::class,
            'order_id'
        )->latestOfMany();
    }
}