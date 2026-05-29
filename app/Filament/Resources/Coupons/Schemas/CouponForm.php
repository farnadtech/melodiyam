<?php

namespace App\Filament\Resources\Coupons\Schemas;

use App\Filament\Forms\Components\JalaliDatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات اصلی کد تخفیف')->schema([
                TextInput::make('code')
                    ->label('کد تخفیف')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('مثلاً: WELCOME2026'),
                Select::make('type')
                    ->label('نوع تخفیف')
                    ->options([
                        'fixed' => 'مبلغ ثابت',
                        'percent' => 'درصد',
                    ])
                    ->required()
                    ->default('percent'),
                TextInput::make('value')
                    ->label('مقدار')
                    ->numeric()
                    ->required()
                    ->helperText('در صورت انتخاب درصد، عدد بین ۱ تا ۱۰۰ وارد کنید.'),
                TextInput::make('max_discount')
                    ->label('حداکثر تخفیف (تومان)')
                    ->numeric()
                    ->helperText('مخصوص تخفیف‌های درصدی. سقف تخفیف را مشخص می‌کند.'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('محدودیت‌ها و شرایط')->schema([
                TextInput::make('min_purchase')
                    ->label('حداقل مبلغ خرید (تومان)')
                    ->numeric()
                    ->default(0),
                TextInput::make('limit_per_user')
                    ->label('تعداد استفاده برای هر کاربر')
                    ->numeric()
                    ->placeholder('نامحدود'),
                TextInput::make('total_limit')
                    ->label('تعداد کل استفاده‌های مجاز')
                    ->numeric()
                    ->placeholder('نامحدود'),
                Select::make('applicable_to')
                    ->label('قابل استفاده برای')
                    ->multiple()
                    ->options([
                        'tracks' => 'خرید تک آهنگ',
                        'albums' => 'خرید آلبوم',
                        'plans' => 'اشتراک کاربران (Premium)',
                        'artist_plans' => 'پلن‌های هنرمندان',
                    ])
                    ->placeholder('همه موارد'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('زمان‌بندی و وضعیت')->schema([
                JalaliDatePicker::make('starts_at')
                    ->label('تاریخ شروع')
                    ->nullable(),
                JalaliDatePicker::make('expires_at')
                    ->label('تاریخ انقضا')
                    ->nullable(),
                Toggle::make('is_active')
                    ->label('فعال')
                    ->default(true),
            ])->columns(3),
        ]);
    }
}
