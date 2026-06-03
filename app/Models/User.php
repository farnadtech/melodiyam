<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name', 'username', 'email', 'phone', 'password', 'avatar', 'bio',
        'birth_date', 'gender', 'country', 'city', 'type', 'is_active',
        'is_premium', 'premium_expires_at', 'preferences',
        'email_verified_at', 'phone_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'premium_expires_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
            'is_active' => 'boolean',
            'is_premium' => 'boolean',
            'birth_date' => 'date',
        ];
    }

    // ── Relationships ──

    public function artist(): HasOne
    {
        return $this->hasOne(Artist::class);
    }

    public function playlists(): HasMany
    {
        return $this->hasMany(Playlist::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->latest();
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function follows(): HasMany
    {
        return $this->hasMany(Follow::class);
    }

    public function followingUsers(): HasMany
    {
        return $this->hasMany(Follow::class)->where('followable_type', User::class);
    }

    public function followingArtists(): HasMany
    {
        return $this->hasMany(Follow::class)->where('followable_type', Artist::class);
    }

    public function followers(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function reposts(): HasMany
    {
        return $this->hasMany(Repost::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function streams(): HasMany
    {
        return $this->hasMany(Stream::class);
    }

    public function recentlyPlayed(): HasMany
    {
        return $this->hasMany(RecentlyPlayed::class)->orderByDesc('played_at');
    }

    public function podcasts(): HasMany
    {
        return $this->hasMany(Podcast::class);
    }

    public function podcastSubscriptions(): HasMany
    {
        return $this->hasMany(PodcastSubscription::class);
    }

    public function subscribedPodcasts()
    {
        return $this->belongsToMany(Podcast::class, 'podcast_subscriptions')
            ->withTimestamps();
    }

    public function canUploadMusic(): bool
    {
        $plan = $this->activeSubscription?->plan;

        if (!$plan) {
            // Check if user is an artist, maybe they have different rules?
            // But the user specifically asked for Plan based permissions.
            return false;
        }

        if (!$plan->can_upload_music) {
            return false;
        }

        if ($plan->max_music_uploads > 0) {
            $uploadedCount = $this->tracks()->count();
            if ($uploadedCount >= $plan->max_music_uploads) {
                return false;
            }
        }

        return true;
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(NotificationLog::class);
    }

    // ── Helpers ──

    public function isArtist(): bool
    {
        return $this->type === 'artist';
    }

    public function isListener(): bool
    {
        return in_array($this->type, ['user', 'listener', null, '']);
    }

    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }

    public function isModerator(): bool
    {
        return $this->type === 'moderator';
    }

    public function hasUsedTrial(): bool
    {
        return $this->subscriptions()->where('is_trial', true)->exists();
    }

    public function isPremium(): bool
    {
        if ($this->is_premium && $this->premium_expires_at?->isFuture()) {
            return true;
        }

        // Fallback check to active subscription relationship
        return $this->activeSubscription()->exists();
    }

    public function canDownload(): bool
    {
        return $this->activeSubscription?->plan?->includes_downloads ?? false;
    }

    public function hasLiked($likeable): bool
    {
        return $this->likes()
            ->where('likeable_type', get_class($likeable))
            ->where('likeable_id', $likeable->id)
            ->exists();
    }

    public function isFollowing($followable): bool
    {
        return $this->follows()
            ->where('followable_type', get_class($followable))
            ->where('followable_id', $followable->id)
            ->exists();
    }

    public function getOrCreateWallet(): Wallet
    {
        return $this->wallet()->firstOrCreate([], ['balance' => 0]);
    }

    public function getAvatarUrl(): string
    {
        if ($this->artist && $this->artist->cover_image) {
            return asset('storage/' . $this->artist->cover_image);
        }
        
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/default-avatar.png');
    }
}
