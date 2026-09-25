<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'name',
        'placement',
        'image_path',
        'mobile_image_path',
        'alt_text',
        'link_url',
        'open_new_tab',
        'sort_order',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'open_new_tab' => 'boolean',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    /**
     * Banner yang sedang aktif dan berada dalam jadwal tayang.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $query) {
                $query
                    ->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function (Builder $query) {
                $query
                    ->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }

    /**
     * Filter posisi banner.
     */
    public function scopePlacement(
        Builder $query,
        string $placement
    ): Builder {
        return $query->where('placement', $placement);
    }

    /**
     * Urutan banner.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderByDesc('created_at');
    }

    /**
     * URL gambar desktop.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * URL gambar mobile.
     */
    public function getMobileImageUrlAttribute(): ?string
    {
        if (!$this->mobile_image_path) {
            return null;
        }

        return asset('storage/' . $this->mobile_image_path);
    }
}

