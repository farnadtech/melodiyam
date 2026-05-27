<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\JalaliDatePicker;
use App\Filament\Resources\TrackResource\Pages;
use App\Helpers\Jalali;
use App\Models\Track;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TrackResource extends Resource
{
    protected static ?string $model = Track::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-musical-note';
    protected static string | \UnitEnum | null $navigationGroup = 'محتوا';
    protected static ?string $modelLabel = 'آهنگ';
    protected static ?string $pluralModelLabel = 'آهنگ‌ها';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات آهنگ')->schema([
                Forms\Components\Select::make('artist_id')->label('هنرمند')
                    ->relationship('artist', 'display_name')->required()->searchable()->preload(),
                Forms\Components\Select::make('album_id')->label('آلبوم')
                    ->relationship('album', 'title')->searchable()->preload(),
                Forms\Components\Select::make('genre_id')->label('ژانر')
                    ->relationship('genre', 'name_fa')->searchable()->preload(),
                Forms\Components\TextInput::make('title')->label('عنوان')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->label('توضیحات')->rows(2),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('فایل و مدیا')->schema([
                Forms\Components\FileUpload::make('cover_image')->label('تصویر کاور')
                    ->image()->directory('tracks/covers')->disk('public')->visibility('public')->maxSize(5120),
                Forms\Components\FileUpload::make('file_path')->label('فایل اصلی (320kbps)')
                    ->directory('tracks/audio')->disk('public')->visibility('public')->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav']),
                Forms\Components\FileUpload::make('file_path_128')->label('فایل 128kbps')
                    ->directory('tracks/audio/128')->disk('public')->visibility('public')->acceptedFileTypes(['audio/mpeg', 'audio/mp3']),
                Forms\Components\TextInput::make('file_url')->label('آدرس خارجی فایل')->url(),
            ])->columns(2),


            \Filament\Schemas\Components\Section::make('وضعیت و انتشار')->schema([
                Forms\Components\Select::make('status')->label('وضعیت')
                    ->options(['draft' => 'پیش‌نویس', 'scheduled' => 'زمان‌بندی', 'published' => 'منتشر', 'archived' => 'بایگانی'])
                    ->required()->default('draft'),
                JalaliDatePicker::make('release_date')->label('تاریخ انتشار/ریلیز (شمسی)'),
                Forms\Components\Toggle::make('is_explicit')->label('محتوای نامناسب'),
                Forms\Components\Toggle::make('is_downloadable')->label('قابل دانلود'),
                Forms\Components\Toggle::make('is_premium_only')->label('فقط پریمیوم'),
                Forms\Components\Toggle::make('is_featured')->label('ویژه'),
            ])->columns(3),

            \Filament\Schemas\Components\Section::make('قیمت‌گذاری و فروش')->schema([
                Forms\Components\Toggle::make('is_for_sale')
                    ->label('قابل فروش')
                    ->helperText('فعال کنید تا آهنگ به صورت تکی قابل خرید باشد')
                    ->live(),
                Forms\Components\TextInput::make('price')
                    ->label('قیمت اصلی (تومان)')
                    ->numeric()
                    ->nullable()
                    ->suffix('تومان')
                    ->visible(fn($get) => $get('is_for_sale'))
                    ->required(fn($get) => $get('is_for_sale')),
                Forms\Components\TextInput::make('discount_price')
                    ->label('قیمت با تخفیف (تومان)')
                    ->numeric()
                    ->nullable()
                    ->suffix('تومان')
                    ->visible(fn($get) => $get('is_for_sale'))
                    ->helperText('خالی = بدون تخفیف'),
                Forms\Components\TextInput::make('preview_seconds')
                    ->label('پیش‌نمایش (ثانیه)')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->suffix('ثانیه')
                    ->visible(fn($get) => $get('is_for_sale'))
                    ->helperText('۰ = بدون پیش‌نمایش، مثلاً ۳۰ = کاربر ۳۰ ثانیه اول را رایگان می‌شنود'),
            ])->columns(3),

            \Filament\Schemas\Components\Section::make('متن آهنگ')->schema([
                Forms\Components\Textarea::make('lyrics')->label('متن آهنگ')->rows(8),
            ])->collapsible(),

            \Filament\Schemas\Components\Section::make('SEO')->schema([
                Forms\Components\TextInput::make('seo_title')->label('عنوان SEO'),
                Forms\Components\Textarea::make('seo_description')->label('توضیحات SEO')->rows(2),
            ])->collapsible()->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('کاور')->circular()->disk('public'),
                Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable()->sortable()->limit(30),
                Tables\Columns\TextColumn::make('artist.display_name')->label('هنرمند')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('album.title')->label('آلبوم')->limit(20),
                Tables\Columns\BadgeColumn::make('status')->label('وضعیت')
                    ->colors(['gray' => 'draft', 'warning' => 'scheduled', 'success' => 'published', 'danger' => 'archived']),
                Tables\Columns\TextColumn::make('play_count')->label('پخش')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('like_count')->label('لایک')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label('ویژه')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('تاریخ')
                    ->formatStateUsing(fn ($state) => $state ? Jalali::format($state, 'Y/m/d') : '-')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('وضعیت')
                    ->options(['draft' => 'پیش‌نویس', 'published' => 'منتشر', 'archived' => 'بایگانی']),
                Tables\Filters\SelectFilter::make('artist_id')->label('هنرمند')
                    ->relationship('artist', 'display_name')->searchable()->preload(),
                Tables\Filters\TernaryFilter::make('is_featured')->label('ویژه'),
                Tables\Filters\TernaryFilter::make('is_premium_only')->label('فقط پریمیوم'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTracks::route('/'),
            'create' => Pages\CreateTrack::route('/create'),
            'edit' => Pages\EditTrack::route('/{record}/edit'),
        ];
    }
}
