<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Album extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'artist_id', 'title', 'title_en', 'slug', 'description', 'cover_image',
        'type', 'genre_id', 'release_date', 'status', 'published_at',
        'is_explicit', 'is_featured', 'play_count', 'like_count',
        'upc', 'copyright', 'seo_title', 'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'published_at' => 'datetime',
            'is_explicit' => 'boolean',
            'is_featured' => 'boolean',
            'play_count' => 'integer',
            'like_count' => 'integer',
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

    // ── Relationships ──

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class)->orderBy('disc_number')->orderBy('track_number');
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // ── Scopes ──

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // ── Helpers ──

    public function getTotalDurationAttribute(): int
    {
        return $this->tracks()->sum('duration');
    }

    public function getTracksCountAttribute(): int
    {
        return $this->tracks()->count();
    }
}
