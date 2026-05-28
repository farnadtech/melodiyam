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

    public function podcasts(): HasMany
    {
        return $this->hasMany(Podcast::class);
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

    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ArtistSubscription::class);
    }

    public function activeSubscription(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ArtistSubscription::class)
            ->where('status', 'active')
            ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->latestOfMany();
    }

    public function earnings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ArtistEarning::class);
    }

    public function pendingEarnings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->earnings()->where('status', 'pending');
    }

    public function paidEarnings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->earnings()->where('status', 'paid');
    }

    public function getTotalEarningsToman(): int
    {
        return $this->earnings()->sum('earning_amount_toman');
    }

    public function getPendingEarningsToman(): int
    {
        return $this->pendingEarnings()->sum('earning_amount_toman');
    }

    public function getPaidEarningsToman(): int
    {
        return $this->paidEarnings()->sum('earning_amount_toman');
    }

    // ── Helpers ──

    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription()->exists();
    }

    public function canUploadTrack(): bool
    {
        $required = \App\Models\Setting::get('artist_subscription_required', '0') === '1';
        $sub = $this->activeSubscription;
        if (!$sub) return !$required;
        return $sub->canUploadTrack();
    }

    public function canUploadAlbum(): bool
    {
        $required = \App\Models\Setting::get('artist_subscription_required', '0') === '1';
        $sub = $this->activeSubscription;
        if (!$sub) return !$required;
        return $sub->canUploadAlbum();
    }

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
        if ($this->user?->avatar) {
            return asset('storage/' . $this->user->avatar);
        }
        return asset('images/default-avatar.png');
    }
}
