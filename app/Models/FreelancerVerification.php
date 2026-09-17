<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelancerVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_profile_id',
        'full_name',
        'identity_type',
        'identity_number',
        'identity_document_path',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'status',
        'rejection_reason',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'identity_number' => 'encrypted',
        'bank_account_number' => 'encrypted',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(
            FreelancerProfile::class
        );
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'reviewed_by'
        );
    }
}