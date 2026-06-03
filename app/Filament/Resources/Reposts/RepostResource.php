<?php

namespace App\Filament\Resources\Reposts;

use App\Filament\Resources\Reposts\Pages;
use App\Models\Repost;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RepostResource extends Resource
{
    protected static ?string $model = Repost::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-path';
    protected static string | \UnitEnum | null $navigationGroup = 'مدیریت موسیقی';
    protected static ?string $modelLabel = 'بازنشر';
    protected static ?string $pluralModelLabel = 'بازنشرها';
    protected static ?int $navigationSort = 6;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('کاربر')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('repostable_type')->label('نوع محتوا')->formatStateUsing(fn($state) => match(true) {
                    str_contains($state, 'Track') => 'آهنگ',
                    str_contains($state, 'Album') => 'آلبوم',
                    str_contains($state, 'PodcastEpisode') => 'قسمت پادکست',
                    str_contains($state, 'Podcast') => 'پادکست',
                    default => str_replace('App\Models\\', '', $state),
                })->badge(),
                Tables\Columns\TextColumn::make('repostable_id')->label('شناسه محتوا'),
                Tables\Columns\TextColumn::make('ip_address')->label('آدرس آی‌پی')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('تاریخ')->formatStateUsing(fn($state) => \App\Helpers\Jalali::format($state, 'Y/m/d H:i'))->sortable(),
            ])
            ->actions([
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageReposts::route('/'),
        ];
    }
}
