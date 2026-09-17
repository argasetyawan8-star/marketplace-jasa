<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelancerEducation extends Model
{
    use HasFactory;

    protected $table = 'freelancer_educations';

    protected $fillable = [
        'freelancer_profile_id',
        'institution',
        'field_of_study',
        'start_year',
        'end_year',
    ];

    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(FreelancerProfile::class, 'freelancer_profile_id');
    }
}