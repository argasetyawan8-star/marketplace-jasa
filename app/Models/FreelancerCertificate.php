<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelancerCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_profile_id',
        'name',
        'issuer',
        'year',
        'credential_url',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }

    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(FreelancerProfile::class);
    }
}