<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_id',
        'playable_id',
        'playable_type',
        'play_count',
        'earning_amount_toman',
        'status',
        'paid_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'play_count' => 'integer',
            'earning_amount_toman' => 'integer',
            'paid_at' => 'datetime',
        ];
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function playable()
    {
        return $this->morphTo();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
