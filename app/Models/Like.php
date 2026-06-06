<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'likeable_type', 'likeable_id', 'created_at'];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likeable()
    {
        return $this->morphTo();
    }

    protected static function booted(): void
    {
        static::creating(function ($like) {
            $like->created_at = $like->created_at ?? now();
        });

        static::created(function ($like) {
            $target = $like->likeable;
            if (!$target) return;
            
            $user = $like->user;
            
            // Get Owner
            $owner = null;
            if (method_exists($target, 'user')) $owner = $target->user;
            elseif (isset($target->artist) && $target->artist) $owner = $target->artist->user;
            elseif (isset($target->user_id)) $owner = User::find($target->user_id);

            if ($owner && $owner->id !== $user->id) {
                \App\Services\NotificationDispatcher::dispatch('track_liked', [
                    'track_title' => $target->title ?? ($target->name ?? 'محتوا'),
                    'user_name' => $user->name,
                ], $owner);
            }
        });
    }
}
