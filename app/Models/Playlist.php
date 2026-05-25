<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Playlist extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'cover_image',
        'visibility', 'is_system', 'is_featured', 'is_sponsored',
        'followers_count', 'tracks_count', 'total_duration',
    ];

    protected function casts(): array
    {
        return [
            'is_system' => 'boolean',
            'is_featured' => 'boolean',
            'is_sponsored' => 'boolean',
            'followers_count' => 'integer',
            'tracks_count' => 'integer',
            'total_duration' => 'integer',
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

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'playlist_track')
            ->withPivot('position', 'added_by')
            ->withTimestamps()
            ->orderBy('playlist_track.position');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'playlist_followers')
            ->withTimestamps();
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function isPublic(): bool
    {
        return $this->visibility === 'public';
    }

    public function isCollaborative(): bool
    {
        return $this->visibility === 'collaborative';
    }

    public function recalculate(): void
    {
        $this->update([
            'tracks_count' => $this->tracks()->count(),
            'total_duration' => $this->tracks()->sum('duration'),
        ]);
    }
}
