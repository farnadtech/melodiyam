<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecentlyPlayed extends Model
{
    public $timestamps = false;

    protected $table = 'recently_played';

    protected $fillable = [
        'user_id', 'playable_type', 'playable_id', 'progress', 'played_at',
    ];

    protected function casts(): array
    {
        return [
            'played_at' => 'datetime',
            'progress' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function playable()
    {
        return $this->morphTo();
    }
}
