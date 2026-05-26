<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Plan extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name', 'name_fa', 'slug', 'description', 'description_fa',
        'type', 'price', 'duration_days', 'trial_days', 'features', 'is_active',
        'is_popular', 'sort_order', 'max_devices', 'audio_quality',
        'ad_free', 'offline_mode', 'unlimited_skips', 'includes_paid_content',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'ad_free' => 'boolean',
            'offline_mode' => 'boolean',
            'unlimited_skips' => 'boolean',
            'includes_paid_content' => 'boolean',
            'price' => 'decimal:0',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isFree(): bool
    {
        return $this->type === 'free';
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->isFree()) {
            return 'رایگان';
        }
        return number_format($this->price) . ' تومان';
    }
}
