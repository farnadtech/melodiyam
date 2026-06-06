<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'followable_type', 'followable_id', 'created_at'];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function followable()
    {
        return $this->morphTo();
    }

    protected static function booted(): void
    {
        static::creating(function ($follow) {
            $follow->created_at = $follow->created_at ?? now();
        });

        static::created(function ($follow) {
            $target = $follow->followable;
            if (!$target) return;

            // Increment followers_count on the target if column exists
            if (\Illuminate\Support\Facades\Schema::hasColumn($target->getTable(), 'followers_count')) {
                $target->increment('followers_count');
            }

            $user = $follow->user;
            
            // If following a user directly
            if ($target instanceof User) {
                \App\Services\NotificationDispatcher::dispatch('user_followed', [
                    'follower_name' => $user->name,
                ], $target);
            } 
            // If following an artist
            elseif ($target instanceof Artist && $target->user) {
                \App\Services\NotificationDispatcher::dispatch('user_followed', [
                    'follower_name' => $user->name,
                ], $target->user);
            }
        });

        static::deleted(function ($follow) {
            $target = $follow->followable;
            if (!$target) return;

            // Decrement followers_count on the target if column exists
            if (\Illuminate\Support\Facades\Schema::hasColumn($target->getTable(), 'followers_count')) {
                $target->decrement('followers_count');
            }
        });
    }
}
