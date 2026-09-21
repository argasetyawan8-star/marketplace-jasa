<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisputeMessage extends Model
{
    protected $fillable = [
        'dispute_id',
        'user_id',
        'message',
    ];

    public function dispute(): BelongsTo
    {
        return $this->belongsTo(
            Dispute::class,
            'dispute_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}