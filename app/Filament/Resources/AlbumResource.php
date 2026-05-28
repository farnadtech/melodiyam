<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\JalaliDatePicker;
use App\Filament\Resources\AlbumResource\Pages;
use App\Helpers\Jalali;
use App\Models\Album;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class AlbumResource extends Resource
{
    protected static ?string $model = Album::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string | \UnitEnum | null $navigationGroup = 'محتوا';
    protected static ?string $modelLabel = 'آلبوم';
    protected static ?string $pluralModelLabel = 'آلبوم‌ها';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() > 0 ? 'warning' : null;
    }

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات آلبوم')->schema([
                Forms\Components\Select::make('artist_id')->label('هنرمند')
                    ->relationship('artist', 'display_name')->required()->searchable()->preload(),
                Forms\Components\Select::make('genre_id')->label('ژانر')
                    ->relationship('genre', 'name_fa')->searchable()->preload(),
                Forms\Components\TextInput::make('title')->label('عنوان')->required(),
                Forms\Components\Select::make('type')->label('نوع')
                    ->options(['album' => 'آلبوم', 'single' => 'سینگل', 'ep' => 'EP', 'compilation' => 'کامپایل'])->required(),
                Forms\Components\Textarea::make('description')->label('توضیحات')->rows(2),
                Forms\Components\FileUpload::make('cover_image')->label('تصویر کاور')->image()->directory('albums')->disk('public')->visibility('public'),
                JalaliDatePicker::make('release_date')->label('تاریخ ریلیز (شمسی)'),
            ])->columns(2),
            \Filament\Schemas\Components\Section::make('وضعیت')->schema([
                Forms\Components\Select::make('status')->label('وضعیت')
                    ->options([
                        'draft' => 'پیش‌نویس',
                        'pending' => 'در انتظار تایید',
                        'published' => 'منتشر',
                        'archived' => 'بایگانی'
                    ])->required(),
                Forms\Components\Toggle::make('is_explicit')->label('نامناسب'),
                Forms\Components\Toggle::make('is_featured')->label('ویژه'),
            ])->columns(3),

            \Filament\Schemas\Components\Section::make('قیمت‌گذاری و فروش')->schema([
                Forms\Components\Toggle::make('is_for_sale')
                    ->label('آلبوم قابل خرید')
                    ->helperText('فعال کنید تا آلبوم به صورت کامل قابل خرید باشد')
                    ->live(),
                Forms\Components\TextInput::make('price')
                    ->label('قیمت اصلی (تومان)')
                    ->numeric()->nullable()->suffix('تومان')
                    ->visible(fn($get) => $get('is_for_sale'))
                    ->required(fn($get) => $get('is_for_sale')),
                Forms\Components\TextInput::make('discount_price')
                    ->label('قیمت با تخفیف (تومان)')
                    ->numeric()->nullable()->suffix('تومان')
                    ->visible(fn($get) => $get('is_for_sale'))
                    ->helperText('خالی = بدون تخفیف'),
                Forms\Components\TextInput::make('preview_seconds')
                    ->label('پیش‌نمایش (ثانیه)')
                    ->numeric()->default(0)->minValue(0)->suffix('ثانیه')
                    ->visible(fn($get) => $get('is_for_sale'))
                    ->helperText('۰ = بدون پیش‌نمایش'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('کاور')->circular()->disk('public'),
                Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('artist.display_name')->label('هنرمند')->searchable(),
                Tables\Columns\BadgeColumn::make('type')->label('نوع')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'album' => 'آلبوم',
                        'single' => 'سینگل',
                        'ep' => 'EP',
                        'compilation' => 'کامپایل',
                        default => $state,
                    }),
                Tables\Columns\BadgeColumn::make('status')->label('وضعیت')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'draft' => 'پیش‌نویس',
                        'pending' => 'در انتظار تایید',
                        'published' => 'منتشر',
                        'archived' => 'بایگانی',
                        default => $state,
                    })
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'pending',
                        'success' => 'published',
                        'danger' => 'archived'
                    ]),
                Tables\Columns\TextColumn::make('play_count')->label('پخش')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('release_date')->label('ریلیز')
                    ->formatStateUsing(fn ($state) => $state ? Jalali::format($state, 'Y/m/d') : '-')
                    ->sortable(),
            ])
            ->actions([\Filament\Actions\EditAction::make()])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlbums::route('/'),
            'create' => Pages\CreateAlbum::route('/create'),
            'edit' => Pages\EditAlbum::route('/{record}/edit'),
        ];
    }
}
