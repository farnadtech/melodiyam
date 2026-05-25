<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Artist extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'user_id', 'display_name', 'slug', 'bio', 'cover_image',
        'website', 'instagram', 'twitter', 'telegram',
        'verification_status', 'verified_at', 'is_featured',
        'monthly_listeners', 'total_streams', 'followers_count', 'balance',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'is_featured' => 'boolean',
            'monthly_listeners' => 'integer',
            'total_streams' => 'integer',
            'followers_count' => 'integer',
            'balance' => 'decimal:0',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('display_name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function featuringTracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'artist_track')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function followers(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    // ── Helpers ──

    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->verification_status === 'pending';
    }

    public function getAvatarUrl(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-cover.png');
    }
}
