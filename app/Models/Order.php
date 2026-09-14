<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Commission;


class Order extends Model
{
    protected $fillable = [
        'client_id',
        'freelancer_profile_id',
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
    | Client
    |--------------------------------------------------------------------------
    */

    public function client(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'client_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Freelancer
    |--------------------------------------------------------------------------
    */

    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(
            FreelancerProfile::class,
            'freelancer_profile_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Order Items
    |--------------------------------------------------------------------------
    */

    public function items(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
            'order_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    public function payment(): HasOne
    {
        return $this->hasOne(
            Payment::class,
            'order_id'
        );
    }

    public function deliveries(): HasMany
{
    return $this->hasMany(Delivery::class);
}

public function commission(): HasOne
{
    return $this->hasOne(Commission::class);
}

public function review(): HasOne
{
    return $this->hasOne(Review::class);
}
}
