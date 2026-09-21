<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispute extends Model
{
    protected $fillable = [
        'dispute_number',
        'order_id',
        'opened_by',
        'opened_by_role',
        'category',
        'reason',
        'status',
        'resolution',
        'resolution_note',
        'resolved_by',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(
            Order::class,
            'order_id'
        );
    }

    public function opener(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'opened_by'
        );
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'resolved_by'
        );
    }

    public function messages(): HasMany
    {
        return $this->hasMany(
            DisputeMessage::class,
            'dispute_id'
        )->latest('id');
    }

    public function evidences(): HasMany
    {
        return $this->hasMany(
            DisputeEvidence::class,
            'dispute_id'
        )->latest('id');
    }
}