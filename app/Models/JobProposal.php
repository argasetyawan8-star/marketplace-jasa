<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'freelancer_profile_id',
        'display_name',
        'phone',
        'message',
        'relevant_info',
        'portfolio_url',
        'selected_experience_id',
        'price',
        'delivery_days',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(
            FreelancerProfile::class,
            'freelancer_profile_id'
        );
    }

    public function selectedExperience(): BelongsTo
    {
        return $this->belongsTo(
            FreelancerExperience::class,
            'selected_experience_id'
        );
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(
            JobProposalPortfolio::class,
            'job_proposal_id'
        );
    }

    public function conversation(): HasOne
    {
        return $this->hasOne(
            JobConversation::class,
            'job_proposal_id'
        );
    }
}