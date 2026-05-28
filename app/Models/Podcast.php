<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Podcast extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'user_id', 'artist_id', 'title', 'slug', 'description', 'cover_image',
        'category', 'language', 'status', 'is_explicit', 'is_featured',
        'subscribers_count',
    ];

    protected function casts(): array
    {
        return [
            'is_explicit' => 'boolean',
            'is_featured' => 'boolean',
            'subscribers_count' => 'integer',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(PodcastEpisode::class)->orderByDesc('episode_number');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
