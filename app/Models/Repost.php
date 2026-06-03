<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Repost extends Model
{
    protected $fillable = ['user_id', 'repostable_type', 'repostable_id', 'ip_address'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function repostable(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function booted()
    {
        static::created(function ($repost) {
            Activity::create([
                'user_id' => $repost->user_id,
                'type' => 'reposted',
                'subject_id' => $repost->id,
                'subject_type' => get_class($repost),
                'ip_address' => request()->ip(),
            ]);

            // Increment repost count on the subject if column exists
            $subject = $repost->repostable;
            if ($subject && \Illuminate\Support\Facades\Schema::hasColumn($subject->getTable(), 'repost_count')) {
                $subject->increment('repost_count');
            }
        });

        static::deleted(function ($repost) {
            Activity::where([
                'type' => 'reposted',
                'subject_id' => $repost->id,
                'subject_type' => get_class($repost),
            ])->delete();

            // Decrement repost count if column exists
            $subject = $repost->repostable;
            if ($subject && \Illuminate\Support\Facades\Schema::hasColumn($subject->getTable(), 'repost_count')) {
                $subject->decrement('repost_count');
            }
        });
    }
}
