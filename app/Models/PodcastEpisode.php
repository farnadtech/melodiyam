<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PodcastEpisode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'podcast_id', 'title', 'slug', 'description', 'show_notes',
        'cover_image', 'file_path', 'file_url', 'duration',
        'season_number', 'episode_number', 'status', 'published_at',
        'is_explicit', 'is_premium_only', 'play_count', 'like_count',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_explicit' => 'boolean',
            'is_premium_only' => 'boolean',
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

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getFormattedDurationAttribute(): string
    {
        return $this->formattedDuration();
    }

    public function formattedDuration(): string
    {
        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;
        return $hours > 0
            ? sprintf('%d:%02d:%02d', $hours, $minutes, $seconds)
            : sprintf('%d:%02d', $minutes, $seconds);
    }
}
