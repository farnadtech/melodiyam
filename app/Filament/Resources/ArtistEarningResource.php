<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\JalaliDatePicker;
use App\Filament\Resources\ArtistEarningResource\Pages;
use App\Helpers\Jalali;
use App\Models\ArtistEarning;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ArtistEarningResource extends Resource
{
    protected static ?string $model = ArtistEarning::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';
    protected static string | \UnitEnum | null $navigationGroup = 'مالی';
    protected static ?string $modelLabel = 'درآمد هنرمند';
    protected static ?string $pluralModelLabel = 'درآمد هنرمندان';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات درآمد')->schema([
                Forms\Components\Select::make('artist_id')
                    ->label('هنرمند')
                    ->relationship('artist', 'display_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('play_count')
                    ->label('تعداد پخش')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('earning_amount_toman')
                    ->label('مبلغ درآمد (تومان)')
                    ->numeric()
                    ->required(),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('وضعیت پرداخت')->schema([
                Forms\Components\Select::make('status')
                    ->label('وضعیت')
                    ->options([
                        'pending' => 'در انتظار پرداخت',
                        'paid' => 'پرداخت شده',
                        'cancelled' => 'لغو شده',
                    ])
                    ->required(),
                JalaliDatePicker::make('paid_at')
                    ->label('تاریخ پرداخت'),
                Forms\Components\Textarea::make('notes')
                    ->label('یادداشت')
                    ->rows(2),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('artist.display_name')
                    ->label('هنرمند')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('playable.title')
                    ->label('آهنگ/قسمت')
                    ->limit(30),
                Tables\Columns\TextColumn::make('play_count')
                    ->label('پخش')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('earning_amount_toman')
                    ->label('درآمد (تومان)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('وضعیت')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'در انتظار',
                        'paid' => 'پرداخت شده',
                        'cancelled' => 'لغو شده',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->formatStateUsing(fn ($state) => Jalali::format($state, 'Y/m/d'))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'pending' => 'در انتظار',
                        'paid' => 'پرداخت شده',
                        'cancelled' => 'لغو شده',
                    ]),
                Tables\Filters\SelectFilter::make('artist_id')
                    ->label('هنرمند')
                    ->relationship('artist', 'display_name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArtistEarnings::route('/'),
            'create' => Pages\CreateArtistEarning::route('/create'),
            'edit' => Pages\EditArtistEarning::route('/{record}/edit'),
        ];
    }
}
