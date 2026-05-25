<?php

namespace App\Filament\Widgets;

use App\Models\Track;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTracksTable extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'آهنگ‌های جدید';

    public function table(Table $table): Table
    {
        return $table
            ->query(Track::query()->with(['artist', 'album'])->latest()->limit(5))
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(asset('images/default-cover.png')),

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('artist.display_name')
                    ->label('هنرمند')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('play_count')
                    ->label('پخش')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Action::make('edit')
                    ->label('ویرایش')
                    ->url(fn (Track $record): string => route('filament.admin.resources.tracks.edit', $record))
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary'),
            ])
            ->headerActions([
                Action::make('create')
                    ->label('آهنگ جدید')
                    ->url(route('filament.admin.resources.tracks.create'))
                    ->icon('heroicon-m-plus')
                    ->color('primary'),
            ])
            ->paginated(false);
    }
}
