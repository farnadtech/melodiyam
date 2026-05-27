<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'reportable_type',
        'reportable_id',
        'reason',
        'description',
        'status',
        'admin_note',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public static array $reasons = [
        'copyright'  => 'نقض کپی‌رایت',
        'illegal'    => 'محتوای غیرقانونی',
        'spam'       => 'اسپم یا تبلیغات',
        'violence'   => 'محتوای خشونت‌آمیز',
        'other'      => 'سایر',
    ];

    public static array $statuses = [
        'pending'  => 'در انتظار بررسی',
        'reviewed' => 'در حال بررسی',
        'resolved' => 'رسیدگی شد',
        'rejected' => 'رد شد',
    ];

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

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

    public function getReasonLabelAttribute(): string
    {
        return static::$reasons[$this->reason] ?? $this->reason;
    }
}
