<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stream extends Model
{
    protected $fillable = [
        'user_id', 'track_id', 'duration_listened', 'completed',
        'ip_address', 'user_agent', 'country', 'device_type',
    ];

    protected function casts(): array
    {
        return [
            'completed' => 'boolean',
            'duration_listened' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }
}
