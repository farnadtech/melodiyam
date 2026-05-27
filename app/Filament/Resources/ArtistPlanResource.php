<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtistPlanResource\Pages;
use App\Models\ArtistPlan;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ArtistPlanResource extends Resource
{
    protected static ?string $model = ArtistPlan::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string|\UnitEnum|null $navigationGroup = 'مدیریت';
    protected static ?string $modelLabel = 'پلن هنرمند';
    protected static ?string $pluralModelLabel = 'پلن‌های هنرمند';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات پلن')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('نام پلن')->required(),
                Forms\Components\Textarea::make('description')
                    ->label('توضیحات')->rows(2)->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->label('قیمت (تومان)')->numeric()->default(0)
                    ->suffix('تومان')->required(),
                Forms\Components\TextInput::make('duration_days')
                    ->label('مدت (روز)')->numeric()->default(30)->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('فعال')->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتیب نمایش')->numeric()->default(0),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('محدودیت‌ها')
                ->description('مقدار ۰ یعنی نامحدود')
                ->schema([
                    Forms\Components\TextInput::make('max_tracks')
                        ->label('حداکثر آهنگ')->numeric()->default(0)
                        ->helperText('۰ = نامحدود'),
                    Forms\Components\TextInput::make('max_albums')
                        ->label('حداکثر آلبوم')->numeric()->default(0)
                        ->helperText('۰ = نامحدود'),
                    Forms\Components\TextInput::make('max_storage_mb')
                        ->label('حداکثر فضا (MB)')->numeric()->default(0)
                        ->suffix('MB')->helperText('۰ = نامحدود'),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('نام پلن')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('قیمت')->numeric()->sortable()
                    ->formatStateUsing(fn($state) => number_format($state) . ' تومان'),
                Tables\Columns\TextColumn::make('duration_days')
                    ->label('مدت')->formatStateUsing(fn($state) => $state . ' روز'),
                Tables\Columns\TextColumn::make('max_tracks')
                    ->label('آهنگ')->formatStateUsing(fn($state) => $state == 0 ? 'نامحدود' : $state),
                Tables\Columns\TextColumn::make('max_albums')
                    ->label('آلبوم')->formatStateUsing(fn($state) => $state == 0 ? 'نامحدود' : $state),
                Tables\Columns\TextColumn::make('max_storage_mb')
                    ->label('فضا')->formatStateUsing(fn($state) => $state == 0 ? 'نامحدود' : $state . ' MB'),
                Tables\Columns\IconColumn::make('is_active')->label('فعال')->boolean(),
            ])
            ->reorderable('sort_order')
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListArtistPlans::route('/'),
            'create' => Pages\CreateArtistPlan::route('/create'),
            'edit'   => Pages\EditArtistPlan::route('/{record}/edit'),
        ];
    }
}
