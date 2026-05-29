<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'max_discount', 'min_purchase',
        'limit_per_user', 'total_limit', 'used_count',
        'starts_at', 'expires_at', 'is_active', 'applicable_to'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'applicable_to' => 'array',
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_purchase' => 'decimal:2',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coupon_user')
            ->withPivot('used_at');
    }

    public function isValidForUser(User $user, $category = null, $amount = 0): bool
    {
        if (!$this->is_active) return false;
        if ($this->starts_at && $this->starts_at->isFuture()) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->total_limit && $this->used_count >= $this->total_limit) return false;
        
        if ($this->limit_per_user) {
            $userUsage = $this->users()->where('user_id', $user->id)->count();
            if ($userUsage >= $this->limit_per_user) return false;
        }

        if ($amount < $this->min_purchase) return false;

        if ($category && $this->applicable_to) {
            if (!in_array($category, $this->applicable_to)) return false;
        }

        return true;
    }

    public function calculateDiscount($amount): float
    {
        if ($this->type === 'fixed') {
            return min($this->value, $amount);
        }

        $discount = ($amount * $this->value) / 100;
        if ($this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }

        return min($discount, $amount);
    }
}
