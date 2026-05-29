<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ArtistPlan extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'duration_days',
        'max_tracks', 'max_albums', 'max_storage_mb', 'includes_downloads', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active'         => 'boolean',
            'includes_downloads' => 'boolean',
            'price'              => 'integer',
            'duration_days'      => 'integer',
            'max_tracks'         => 'integer',
            'max_albums'         => 'integer',
            'max_storage_mb'     => 'integer',
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
        return $this->hasMany(ArtistSubscription::class, 'plan_id');
    }

    public function isUnlimitedTracks(): bool  { return $this->max_tracks === 0; }
    public function isUnlimitedAlbums(): bool  { return $this->max_albums === 0; }
    public function isUnlimitedStorage(): bool { return $this->max_storage_mb === 0; }
}
