<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobProposalPortfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_proposal_id',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(JobProposal::class, 'job_proposal_id');
    }
}