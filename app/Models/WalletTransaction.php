<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id', 'type', 'amount', 'balance_after', 'description',
        'transactionable_type', 'transactionable_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:0',
            'balance_after' => 'decimal:0',
        ];
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }
}
