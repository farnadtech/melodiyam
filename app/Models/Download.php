<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Download extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'downloadable_type', 'downloadable_id', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($download) {
            $download->created_at = $download->created_at ?: now();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function downloadable(): MorphTo
    {
        return $this->morphTo();
    }
}
