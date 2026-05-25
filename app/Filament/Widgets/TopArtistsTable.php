<?php

namespace App\Filament\Widgets;

use App\Models\Artist;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopArtistsTable extends BaseWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'برترین هنرمندان';

    public function table(Table $table): Table
    {
        return $table
            ->query(Artist::query()->orderByDesc('total_streams')->limit(5))
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(asset('images/default-cover.png')),

                Tables\Columns\TextColumn::make('display_name')
                    ->label('نام')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_streams')
                    ->label('پخش کل')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('followers_count')
                    ->label('دنبال‌کنندگان')
                    ->numeric(),
            ])
            ->actions([
                Action::make('edit')
                    ->label('ویرایش')
                    ->url(fn (Artist $record): string => route('filament.admin.resources.artists.edit', $record))
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary'),
            ])
            ->headerActions([
                Action::make('create')
                    ->label('هنرمند جدید')
                    ->url(route('filament.admin.resources.artists.create'))
                    ->icon('heroicon-m-plus')
                    ->color('primary'),
            ])
            ->paginated(false);
    }
}
