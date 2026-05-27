<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'type', 'media_path', 'media_url',
        'button_text', 'button_url',
        'click_url', 'position', 'duration', 'starts_at', 'ends_at',
        'status', 'impressions', 'clicks', 'max_impressions',
        'budget', 'spent', 'targeting', 'priority',
        'target_plans', 'tracks_between', 'interval_seconds',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'targeting'    => 'array',
            'target_plans' => 'array',
            'budget' => 'decimal:0',
            'spent' => 'decimal:0',
            'impressions' => 'integer',
            'clicks' => 'integer',
        ];
    }

    public function adImpressions(): HasMany
    {
        return $this->hasMany(AdImpression::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }

    public function isActive(): bool
    {
        return $this->status === 'active'
            && $this->starts_at <= now()
            && ($this->ends_at === null || $this->ends_at >= now());
    }

    // Accessors for type-specific media fields (read-only)
    public function getAudioMediaPathAttribute()
    {
        return $this->type === 'audio' ? $this->media_path : null;
    }

    public function getAudioMediaUrlAttribute()
    {
        return $this->type === 'audio' ? $this->media_url : null;
    }

    public function getBannerMediaPathAttribute()
    {
        return $this->type === 'banner' ? $this->media_path : null;
    }

    public function getBannerMediaUrlAttribute()
    {
        return $this->type === 'banner' ? $this->media_url : null;
    }
}
