<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Sale extends Model
{
    protected $fillable = [
        'buyer_id', 'seller_id',
        'saleable_type', 'saleable_id',
        'gross_amount', 'commission_amount', 'net_amount',
        'commission_rule_id', 'status',
        'payment_method', 'transaction_id',
    ];

    protected $casts = [
        'gross_amount'      => 'integer',
        'commission_amount' => 'integer',
        'net_amount'        => 'integer',
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function saleable(): MorphTo
    {
        return $this->morphTo();
    }

    public function commissionRule(): BelongsTo
    {
        return $this->belongsTo(CommissionRule::class);
    }

    protected static function booted()
    {
        static::created(function ($sale) {
            if ($sale->status === 'completed' && $sale->seller) {
                \App\Services\NotificationDispatcher::dispatch('track_purchased_artist', [
                    'track_title' => $sale->saleable->title ?? 'محصول',
                    'amount'      => number_format($sale->gross_amount),
                ], $sale->seller);
            }
        });
    }
}
