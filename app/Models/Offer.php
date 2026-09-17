<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'client_id',
        'freelancer_profile_id',
        'service_id',
        'job_id',
        'job_proposal_id',
        'title',
        'description',
        'price',
        'delivery_days',
        'revision_count',
        'status',
        'expires_at',
        'accepted_at',
        'rejected_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(
            Conversation::class,
            'conversation_id'
        );
    }

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

    public function service(): BelongsTo
    {
        return $this->belongsTo(
            Service::class,
            'service_id'
        );
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(
            Job::class,
            'job_id'
        );
    }

    public function jobProposal(): BelongsTo
    {
        return $this->belongsTo(
            JobProposal::class,
            'job_proposal_id'
        );
    }
}