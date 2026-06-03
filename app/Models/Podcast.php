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

class Podcast extends Model
{
    use HasFactory, SoftDeletes, HasSlug, RecordsActivity;

    protected $fillable = [
        'user_id', 'artist_id', 'title', 'slug', 'description', 'cover_image',
        'category', 'language', 'status', 'is_explicit', 'is_featured',
        'subscribers_count', 'repost_count', 'comment_count', 'share_count', 'like_count', 'is_premium_only',
    ];

    protected $appends = ['cover_url'];

    protected function casts(): array
    {
        return [
            'is_explicit' => 'boolean',
            'is_featured' => 'boolean',
            'is_premium_only' => 'boolean',
            'subscribers_count' => 'integer',
            'repost_count' => 'integer',
            'comment_count' => 'integer',
            'share_count' => 'integer',
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

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-cover.png');
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

    public function subscriptions()
    {
        return $this->hasMany(PodcastSubscription::class);
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reposts(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Repost::class, 'repostable');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
