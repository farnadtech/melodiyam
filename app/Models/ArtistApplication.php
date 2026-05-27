<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistApplication extends Model
{
    protected $fillable = [
        'user_id', 'data', 'status', 'admin_note', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'data'        => 'array',
        'reviewed_at' => 'datetime',
    ];

    public static array $statuses = [
        'pending'   => 'در انتظار بررسی',
        'reviewing' => 'در حال بررسی',
        'approved'  => 'تأیید شده',
        'rejected'  => 'رد شده',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return static::$statuses[$this->status] ?? $this->status;
    }
}
