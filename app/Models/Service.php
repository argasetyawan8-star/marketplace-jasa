<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_profile_id',
        'category_id',
        'subcategory_id',
        'title',
        'slug',
        'description',
        'starting_price',
        'delivery_days',
        'orders_count',
        'rating',
        'reviews_count',
        'thumbnail',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'starting_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    /**
     * Service dimiliki oleh satu freelancer profile.
     */
    public function freelancerProfile(): BelongsTo
    {
        return $this->belongsTo(FreelancerProfile::class);
    }

    /**
     * Service berada dalam satu category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Service berada dalam satu subcategory.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function favorites(): HasMany
{
    return $this->hasMany(Favorite::class);
}
}