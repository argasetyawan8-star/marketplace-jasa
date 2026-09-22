<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi secara mass assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * Kolom yang disembunyikan ketika model diubah menjadi array / JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Profil freelancer milik user.
     */
    public function freelancerProfile(): HasOne
    {
        return $this->hasOne(FreelancerProfile::class);
    }

    /**
     * Semua order yang dibuat oleh client.
     */
    public function clientOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function favorites(): HasMany
{
    return $this->hasMany(Favorite::class, 'client_id');
}

public function profile(): HasOne
{
    return $this->hasOne(Profile::class);
}

public function reviews(): HasMany
{
    return $this->hasMany(Review::class, 'client_id');
}
}