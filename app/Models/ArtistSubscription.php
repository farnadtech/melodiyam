<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistSubscription extends Model
{
    protected $fillable = [
        'artist_id', 'plan_id', 'status', 'starts_at', 'expires_at',
        'tracks_used', 'albums_used', 'storage_used_mb', 'payment_ref', 'granted_by',
    ];

    protected function casts(): array
    {
        return [
            'starts_at'  => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public static array $statuses = [
        'active'    => 'فعال',
        'expired'   => 'منقضی',
        'cancelled' => 'لغو شده',
    ];

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(ArtistPlan::class, 'plan_id');
    }

    public function grantedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'granted_by');
    }

    public function isActive(): bool
    {
        return $this->status === 'active'
            && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function canUploadTrack(): bool
    {
        if (!$this->isActive()) return false;
        if ($this->plan->isUnlimitedTracks()) return true;
        return $this->tracks_used < $this->plan->max_tracks;
    }

    public function canUploadAlbum(): bool
    {
        if (!$this->isActive()) return false;
        if ($this->plan->isUnlimitedAlbums()) return true;
        return $this->albums_used < $this->plan->max_albums;
    }
}
