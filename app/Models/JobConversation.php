<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'job_proposal_id',
        'client_id',
        'freelancer_profile_id',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(JobProposal::class, 'job_proposal_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(
            FreelancerProfile::class,
            'freelancer_profile_id'
        );
    }

    public function messages(): HasMany
    {
        return $this->hasMany(
            JobMessage::class,
            'job_conversation_id'
        );
    }
}