<?php

namespace App\Filament\Resources\Coupons\Tables;

use App\Helpers\Jalali;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('کد')
                    ->copyable()
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('type')
                    ->label('نوع')
                    ->formatStateUsing(fn ($state) => $state === 'fixed' ? 'مبلغ ثابت' : 'درصد'),
                TextColumn::make('value')
                    ->label('مقدار')
                    ->formatStateUsing(fn ($record, $state) => $record->type === 'fixed' ? number_format($state) . ' ت' : $state . '%'),
                TextColumn::make('used_count')
                    ->label('تعداد استفاده')
                    ->sortable(),
                TextColumn::make('total_limit')
                    ->label('سقف کل')
                    ->formatStateUsing(fn ($state) => $state ?: 'نامحدود'),
                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
                TextColumn::make('expires_at')
                    ->label('تاریخ انقضا')
                    ->formatStateUsing(fn ($state) => $state ? Jalali::format($state, 'Y/m/d H:i') : 'نامحدود')
                    ->sortable(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
