<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'commentable_type', 'commentable_id',
        'parent_id', 'body', 'timestamp_at', 'is_approved',
    ];

    protected function casts(): array
    {
        return ['is_approved' => 'boolean'];
    }

    protected static function booted()
    {
        static::created(function ($comment) {
            $target = $comment->commentable;
            if (!$target) return;

            $user = $comment->user;

            // Get Owner
            $owner = null;
            if (method_exists($target, 'user')) $owner = $target->user;
            elseif (isset($target->artist) && $target->artist) $owner = $target->artist->user;
            elseif (isset($target->user_id)) $owner = \App\Models\User::find($target->user_id);

            if ($owner && $owner->id !== $user->id) {
                \App\Services\NotificationDispatcher::dispatch('track_commented', [
                    'track_title' => $target->title ?? ($target->name ?? 'محتوا'),
                    'user_name' => $user->name,
                    'comment_body' => $comment->body,
                ], $owner);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }
}
