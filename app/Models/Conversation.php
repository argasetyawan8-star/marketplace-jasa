<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'freelancer_profile_id',
        'service_id',
        'job_id',
        'job_proposal_id',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

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
        return $this->belongsTo(Service::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function jobProposal(): BelongsTo
    {
        return $this->belongsTo(
            JobProposal::class,
            'job_proposal_id'
        );
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}