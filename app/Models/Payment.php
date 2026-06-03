<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'subscription_id', 'amount', 'tax_amount', 'fee_amount',
        'gateway', 'payment_type', 'payable_type', 'payable_id',
        'authority', 'ref_id', 'status', 'description',
        'gateway_response', 'callback_url', 'mobile',
    ];

    protected function casts(): array
    {
        return [
            'amount'           => 'decimal:0',
            'tax_amount'       => 'decimal:0',
            'fee_amount'       => 'decimal:0',
            'gateway_response' => 'array',
        ];
    }

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    // ── Helpers ──

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function totalAmount(): int
    {
        return (int)$this->amount + (int)$this->tax_amount + (int)$this->fee_amount;
    }

    public function gatewayLabel(): string
    {
        return match ($this->gateway) {
            'zarinpal' => 'زرین‌پال',
            'zibal'    => 'زیبال',
            'payping'  => 'پی‌پینگ',
            default    => $this->gateway,
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'  => 'در انتظار',
            'paid'     => 'پرداخت شده',
            'failed'   => 'ناموفق',
            'refunded' => 'مسترد شده',
            default    => $this->status,
        };
    }

    public function typeLabel(): string
    {
        return match ($this->payment_type) {
            'subscription'        => 'اشتراک کاربر',
            'artist_subscription' => 'اشتراک هنرمند',
            'wallet_deposit'      => 'شارژ کیف پول',
            default               => $this->payment_type,
        };
    }
}
