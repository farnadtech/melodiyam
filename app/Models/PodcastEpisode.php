<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PodcastEpisode extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'podcast_id', 'title', 'slug', 'description', 'show_notes',
        'cover_image', 'file_path', 'file_url', 'duration',
        'season_number', 'episode_number', 'status', 'published_at',
        'is_explicit', 'is_premium_only', 'is_downloadable', 'play_count', 'like_count',
    ];

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

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_explicit' => 'boolean',
            'is_premium_only' => 'boolean',
            'is_downloadable' => 'boolean',
            'duration' => 'integer',
            'play_count' => 'integer',
            'like_count' => 'integer',
        ];
    }

    public function podcast(): BelongsTo
    {
        return $this->belongsTo(Podcast::class);
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function earnings(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(ArtistEarning::class, 'playable');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeSort($query, $sort = 'newest')
    {
        $query->reorder();
        
        switch ($sort) {
            case 'most_played':
                return $query->orderByDesc('play_count')->orderByDesc('created_at');
            case 'most_popular':
                return $query->orderByDesc('like_count')->orderByDesc('created_at');
            case 'most_comments':
                return $query->withCount('comments')->orderByDesc('comments_count')->orderByDesc('created_at');
            case 'oldest':
                return $query->orderByRaw('published_at IS NULL ASC, published_at ASC')->orderBy('created_at');
            case 'newest':
            default:
                return $query->orderByRaw('published_at IS NULL ASC, published_at DESC')->orderByDesc('created_at');
        }
    }

    public function getFormattedDurationAttribute(): string
    {
        return $this->formattedDuration();
    }

    public function formattedDuration(): string
    {
        if (!$this->duration || $this->duration <= 0) {
            $path = $this->getEffectiveStreamPath();
            if ($path && file_exists($path)) {
                $this->duration = \App\Helpers\AudioHelper::getDuration($path);
                if ($this->duration > 0) {
                    $this->save();
                }
            }
        }

        if (!$this->duration || $this->duration <= 0) {
            return '--:--';
        }
        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;
        return $hours > 0
            ? sprintf('%d:%02d:%02d', $hours, $minutes, $seconds)
            : sprintf('%d:%02d', $minutes, $seconds);
    }

    public function getStreamUrl(): ?string
    {
        if ($this->file_url) {
            return $this->file_url;
        }
        if ($this->file_path) {
            return route('podcast.episode.stream', $this);
        }
        return null;
    }

    public function getEffectiveStreamPath(): ?string
    {
        if ($this->file_path && file_exists(storage_path('app/public/' . $this->file_path))) {
            return storage_path('app/public/' . $this->file_path);
        }
        return null;
    }

    public function getCoverUrl(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        if ($this->podcast?->cover_image) {
            return asset('storage/' . $this->podcast->cover_image);
        }
        return asset('images/default-cover.png');
    }

    public function getDownloadUrl(): ?string
    {
        if ($this->file_url) {
            return $this->file_url;
        }
        if ($this->file_path && file_exists(storage_path('app/public/' . $this->file_path))) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }
}
