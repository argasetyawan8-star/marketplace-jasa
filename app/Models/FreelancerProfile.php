<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\FreelancerExperience;
use App\Models\FreelancerEducation;
use App\Models\FreelancerCertificate;
use App\Models\FreelancerSkill;
use App\Models\FreelancerLanguage;



class FreelancerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'headline',
        'bio',
        'avatar',
        'cover_image',
        'location',
        'website',
        'completed_orders',
        'rating',
        'is_available',
        'is_verified',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
    ];

    /**
     * User pemilik profil freelancer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Semua jasa milik freelancer.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Semua order yang masuk ke freelancer.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
 * Wallet freelancer.
 */
public function wallet(): HasOne
{
    return $this->hasOne(Wallet::class);
}

/**
 * Semua pengajuan penarikan freelancer.
 */
public function withdrawals(): HasMany
{
    return $this->hasMany(Withdrawal::class);
}

public function reviews(): HasMany
{
    return $this->hasMany(
        Review::class,
        'freelancer_profile_id'
    );
}

public function experiences(): HasMany
{
    return $this->hasMany(FreelancerExperience::class);
}

public function educations(): HasMany
{
    return $this->hasMany(FreelancerEducation::class);
}

public function certificates(): HasMany
{
    return $this->hasMany(FreelancerCertificate::class);
}

public function skills(): HasMany
{
    return $this->hasMany(FreelancerSkill::class);
}

public function languages(): HasMany
{
    return $this->hasMany(FreelancerLanguage::class);
}

public function verification(): HasOne
{
    return $this->hasOne(
        FreelancerVerification::class
    );
}


}