<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Album extends Model
{
    use HasFactory, SoftDeletes, HasSlug, RecordsActivity;

    protected $fillable = [
        'artist_id', 'title', 'title_en', 'slug', 'description', 'cover_image',
        'type', 'genre_id', 'release_date', 'status', 'published_at',
        'is_explicit', 'is_featured', 'play_count', 'like_count', 'repost_count', 'comment_count', 'share_count',
        'upc', 'copyright', 'seo_title', 'seo_description',
        'price', 'discount_price', 'is_for_sale', 'preview_seconds',
    ];

    protected $appends = ['cover_url'];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'published_at' => 'datetime',
            'is_explicit' => 'boolean',
            'is_featured' => 'boolean',
            'play_count' => 'integer',
            'like_count' => 'integer',
            'repost_count' => 'integer',
            'comment_count' => 'integer',
            'share_count' => 'integer',
            'price' => 'integer',
            'discount_price' => 'integer',
            'is_for_sale' => 'boolean',
            'preview_seconds' => 'integer',
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

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-cover.png');
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

    public function reports(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function reposts(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Repost::class, 'repostable');
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

    public function scopeSort($query, $sort = 'newest')
    {
        $query->reorder();

        switch ($sort) {
            case 'most_played':
            case 'play_count':
                return $query->orderByDesc('play_count')->orderByDesc('created_at');
            case 'most_popular':
            case 'like_count':
                return $query->orderByDesc('like_count')->orderByDesc('created_at');
            case 'oldest':
                return $query->orderByRaw('release_date IS NULL ASC, release_date ASC')->orderBy('created_at');
            case 'release_date':
                return $query->orderByRaw('release_date IS NULL ASC, release_date DESC')->orderByDesc('created_at');
            case 'created_at':
                return $query->orderByDesc('created_at');
            case 'newest':
            default:
                return $query->orderByRaw('release_date IS NULL ASC, release_date DESC')->orderByDesc('created_at');
        }
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

    public function getCoverUrl(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-cover.png');
    }
}
