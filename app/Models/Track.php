<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Track extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'artist_id', 'album_id', 'genre_id', 'title', 'title_en', 'slug',
        'description', 'cover_image', 'duration', 'track_number', 'disc_number',
        'file_path', 'file_path_128', 'file_path_320', 'file_url',
        'lyrics', 'synced_lyrics', 'language', 'is_explicit', 'is_downloadable',
        'is_premium_only', 'status', 'published_at', 'release_date',
        'is_featured', 'play_count', 'like_count', 'download_count', 'share_count',
        'mood', 'bpm', 'key_signature', 'isrc', 'seo_title', 'seo_description',
        'price', 'discount_price', 'is_for_sale', 'preview_seconds',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'release_date' => 'date',
            'synced_lyrics' => 'array',
            'is_explicit' => 'boolean',
            'is_downloadable' => 'boolean',
            'is_premium_only' => 'boolean',
            'is_featured' => 'boolean',
            'duration' => 'integer',
            'play_count' => 'integer',
            'like_count' => 'integer',
            'download_count' => 'integer',
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

    // ── Relationships ──

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_track');
    }

    public function featuringArtists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'artist_track')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, 'playlist_track')
            ->withPivot('position', 'added_by')
            ->withTimestamps();
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

    public function streams(): HasMany
    {
        return $this->hasMany(Stream::class);
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

    public function scopeTrending($query)
    {
        return $query->published()
            ->where('created_at', '>=', now()->subDays(30))
            ->orderByDesc('play_count');
    }

    // ── Helpers ──

    public function getFormattedDurationAttribute(): string
    {
        return $this->formattedDuration();
    }

    public function formattedDuration(): string
    {
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function getStreamUrl(): ?string
    {
        if ($this->file_url) {
            return $this->file_url;
        }
        if ($this->file_path || $this->file_path_128) {
            return route('track.stream', $this);
        }
        return null;
    }

    public function getEffectiveStreamPath(): ?string
    {
        if ($this->file_path && file_exists(storage_path('app/public/' . $this->file_path))) {
            return storage_path('app/public/' . $this->file_path);
        }
        if ($this->file_path_128 && file_exists(storage_path('app/public/' . $this->file_path_128))) {
            return storage_path('app/public/' . $this->file_path_128);
        }
        return null;
    }

    public function getCoverUrl(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        if ($this->album?->cover_image) {
            return asset('storage/' . $this->album->cover_image);
        }
        return asset('images/default-cover.png');
    }
}
