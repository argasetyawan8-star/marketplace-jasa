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

    /*
    |--------------------------------------------------------------------------
    | CLIENT / FREELANCER
    |--------------------------------------------------------------------------
    */

    public function client(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'client_id'
        );
    }

    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(
            FreelancerProfile::class,
            'freelancer_profile_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER DATA
    |--------------------------------------------------------------------------
    */

    public function items(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
            'order_id'
        );
    }

    public function payment(): HasOne
    {
        return $this->hasOne(
            Payment::class,
            'order_id'
        );
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(
            Delivery::class,
            'order_id'
        );
    }

    public function commission(): HasOne
    {
        return $this->hasOne(
            Commission::class
        );
    }

    public function review(): HasOne
    {
        return $this->hasOne(
            Review::class
        );
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(
            Conversation::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CANCELLATION
    |--------------------------------------------------------------------------
    */

    public function cancellationRequests(): HasMany
    {
        return $this->hasMany(
            CancellationRequest::class,
            'order_id'
        );
    }

    public function latestCancellationRequest(): HasOne
    {
        return $this->hasOne(
            CancellationRequest::class,
            'order_id'
        )->latestOfMany();
    }

    /*
    |--------------------------------------------------------------------------
    | DISPUTE
    |--------------------------------------------------------------------------
    */

    public function disputes(): HasMany
    {
        return $this->hasMany(
            Dispute::class,
            'order_id'
        );
    }

    public function activeDispute(): HasOne
    {
        return $this->hasOne(
            Dispute::class,
            'order_id'
        )->whereIn('status', [
            'open',
            'pending_response',
            'under_review',
        ]);
    }
}