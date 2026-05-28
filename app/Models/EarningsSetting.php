<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarningsSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_enabled',
        'plays_threshold',
        'earning_amount_toman',
        'min_payout_toman',
        'payout_description',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'plays_threshold' => 'integer',
            'earning_amount_toman' => 'integer',
            'min_payout_toman' => 'integer',
        ];
    }

    // Singleton pattern - always get the first record
    public static function getSettings(): self
    {
        return self::firstOrCreate([], [
            'is_enabled' => false,
            'plays_threshold' => 100,
            'earning_amount_toman' => 500,
            'min_payout_toman' => 50000,
        ]);
    }
}
