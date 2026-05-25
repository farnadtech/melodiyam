<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';
    protected static string | \UnitEnum | null $navigationGroup = 'اشتراک';
    protected static ?string $modelLabel = 'طرح اشتراک';
    protected static ?string $pluralModelLabel = 'طرح‌های اشتراک';

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('نام')->required(),
            Forms\Components\TextInput::make('name_fa')->label('نام فارسی')->required(),
            Forms\Components\Select::make('type')->label('نوع')
                ->options(['free' => 'رایگان', 'premium' => 'پریمیوم', 'family' => 'خانوادگی', 'student' => 'دانشجو'])->required(),
            Forms\Components\TextInput::make('price')->label('قیمت (تومان)')->numeric()->required(),
            Forms\Components\TextInput::make('duration_days')->label('مدت (روز)')->numeric()->required(),
            Forms\Components\TagsInput::make('features')->label('ویژگی‌ها'),
            Forms\Components\TextInput::make('max_devices')->label('حداکثر دستگاه')->numeric(),
            Forms\Components\Select::make('audio_quality')->label('کیفیت صدا')
                ->options(['normal' => 'معمولی', 'high' => 'بالا', 'lossless' => 'بدون افت']),
            Forms\Components\Toggle::make('ad_free')->label('بدون تبلیغات'),
            Forms\Components\Toggle::make('offline_mode')->label('حالت آفلاین'),
            Forms\Components\Toggle::make('unlimited_skips')->label('رد نامحدود'),
            Forms\Components\Toggle::make('is_active')->label('فعال')->default(true),
            Forms\Components\Toggle::make('is_popular')->label('محبوب'),
            Forms\Components\TextInput::make('sort_order')->label('ترتیب')->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_fa')->label('نام')->sortable(),
                Tables\Columns\BadgeColumn::make('type')->label('نوع'),
                Tables\Columns\TextColumn::make('price')->label('قیمت')->numeric()->suffix(' تومان'),
                Tables\Columns\TextColumn::make('duration_days')->label('مدت')->suffix(' روز'),
                Tables\Columns\IconColumn::make('is_active')->label('فعال')->boolean(),
                Tables\Columns\IconColumn::make('is_popular')->label('محبوب')->boolean(),
            ])
            ->actions([\Filament\Actions\EditAction::make()])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
