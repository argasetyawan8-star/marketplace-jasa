<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CancellationRequest extends Model
{
    protected $fillable = [
        'order_id',
        'requester_id',
        'requester_role',
        'reason',
        'freelancer_note',
        'freelancer_reviewed_at',
        'status',
        'reviewed_by',
        'admin_note',
        'mediation_reason',
        'mediation_requested_at',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'freelancer_reviewed_at' => 'datetime',
            'mediation_requested_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    /**
     * Order yang terkait dengan cancellation.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * User yang pertama kali mengajukan cancellation.
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'requester_id'
        );
    }

    /**
     * Admin yang melakukan mediasi / keputusan akhir.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'reviewed_by'
        );
    }
}