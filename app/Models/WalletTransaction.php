<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id', 'type', 'amount', 'balance_after', 'description',
        'transactionable_type', 'transactionable_id',
        'status', 'reference_number', 'card_number',
        'receipt_image', 'admin_note', 'reviewed_by', 'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'      => 'decimal:0',
            'balance_after' => 'decimal:0',
            'reviewed_at' => 'datetime',
        ];
    }

    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isApproved(): bool  { return $this->status === 'approved'; }
    public function isRejected(): bool  { return $this->status === 'rejected'; }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    protected static function booted()
    {
        static::created(function ($transaction) {
            if ($transaction->type === 'withdrawal' && $transaction->status === 'pending') {
                \App\Services\NotificationDispatcher::dispatch('withdrawal_requested', [
                    'user_name' => $transaction->wallet->user->name ?? 'کاربر',
                    'amount'    => number_format($transaction->amount),
                ]);
            }
        });
    }
}
