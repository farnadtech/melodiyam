<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionRule extends Model
{
    protected $fillable = [
        'name', 'type', 'reference_id',
        'commission_type', 'commission_value',
        'is_active', 'description',
    ];

    protected $casts = [
        'commission_value' => 'float',
        'is_active'        => 'boolean',
    ];

    public function calculateCommission(float $amount): array
    {
        if ($this->commission_type === 'percent') {
            $commission = round($amount * $this->commission_value / 100);
        } else {
            $commission = $this->commission_value;
        }
        return [
            'commission' => (int) $commission,
            'net'        => (int) ($amount - $commission),
        ];
    }

    public static function getApplicableRule(?int $genreId = null, ?int $artistId = null): ?self
    {
        // Artist-specific rule (highest priority)
        if ($artistId) {
            $rule = static::where('type', 'artist')
                ->where('reference_id', $artistId)
                ->where('is_active', true)
                ->first();
            if ($rule) return $rule;
        }

        // Genre-specific rule
        if ($genreId) {
            $rule = static::where('type', 'genre')
                ->where('reference_id', $genreId)
                ->where('is_active', true)
                ->first();
            if ($rule) return $rule;
        }

        // Global rule
        return static::where('type', 'global')->where('is_active', true)->first();
    }
}
