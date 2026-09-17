<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'freelancer_profile_id',
        'price',
        'delivery_days',
        'message',
        'status',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'submitted_at' => 'datetime',
        ];
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(FreelancerProfile::class);
    }
}
