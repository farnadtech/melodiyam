<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\JalaliDatePicker;
use App\Filament\Resources\PodcastEpisodeResource\Pages;
use App\Helpers\Jalali;
use App\Models\PodcastEpisode;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PodcastEpisodeResource extends Resource
{
    protected static ?string $model = PodcastEpisode::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-play-circle';
    protected static string | \UnitEnum | null $navigationGroup = 'محتوا';
    protected static ?string $modelLabel = 'قسمت پادکست';
    protected static ?string $pluralModelLabel = 'قسمت‌های پادکست';
    protected static ?int $navigationSort = 6;

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
            \Filament\Schemas\Components\Section::make('اطلاعات قسمت')->schema([
                Forms\Components\Select::make('podcast_id')->label('پادکست')
                    ->relationship('podcast', 'title')->required()->searchable()->preload(),
                Forms\Components\TextInput::make('title')->label('عنوان قسمت')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->label('توضیحات')->rows(2),
                Forms\Components\Textarea::make('show_notes')->label('یادداشت‌های نمایش')->rows(3),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('فایل و مدیا')->schema([
                Forms\Components\FileUpload::make('cover_image')->label('تصویر کاور')
                    ->image()->directory('podcasts/episodes/covers')->disk('public'),
                Forms\Components\FileUpload::make('file_path')->label('فایل صوتی')
                    ->directory('podcasts/episodes/audio')->disk('public')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg']),
                Forms\Components\TextInput::make('file_url')->label('یا URL فایل')->url(),
                Forms\Components\TextInput::make('duration')->label('مدت زمان (ثانیه)')
                    ->numeric()->default(0)->helperText('0 = خودکار محاسبه می‌شود'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('شماره‌گذاری')->schema([
                Forms\Components\TextInput::make('season_number')->label('شماره فصل')
                    ->numeric()->default(1)->minValue(1),
                Forms\Components\TextInput::make('episode_number')->label('شماره قسمت')
                    ->numeric()->default(1)->minValue(1),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('تنظیمات')->schema([
                Forms\Components\Toggle::make('is_explicit')->label('محتوای نامناسب'),
                Forms\Components\Toggle::make('is_premium_only')->label('فقط پریمیوم'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('وضعیت انتشار')->schema([
                Forms\Components\Select::make('status')->label('وضعیت')
                    ->options([
                        'draft' => 'پیش‌نویس',
                        'pending' => 'در انتظار تایید',
                        'published' => 'منتشر شده',
                        'scheduled' => 'زمان‌بندی'
                    ])
                    ->required()->default('draft'),
                JalaliDatePicker::make('published_at')->label('تاریخ انتشار (شمسی)'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('podcast.title')->label('پادکست')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title')->label('عنوان قسمت')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('season_number')->label('فصل'),
                Tables\Columns\TextColumn::make('episode_number')->label('قسمت'),
                Tables\Columns\BadgeColumn::make('status')->label('وضعیت')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'draft' => 'پیش‌نویس',
                        'pending' => 'در انتظار تایید',
                        'published' => 'منتشر شده',
                        'scheduled' => 'زمان‌بندی',
                        default => $state,
                    })
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'pending',
                        'success' => 'published',
                        'info' => 'scheduled'
                    ]),
                Tables\Columns\TextColumn::make('play_count')->label('پخش')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('published_at')->label('تاریخ انتشار')
                    ->formatStateUsing(fn ($state) => $state ? Jalali::format($state, 'Y/m/d') : '-')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('podcast_id')->label('پادکست')
                    ->relationship('podcast', 'title')->searchable()->preload(),
                Tables\Filters\SelectFilter::make('status')->label('وضعیت')
                    ->options(['draft' => 'پیش‌نویس', 'published' => 'منتشر', 'scheduled' => 'زمان‌بندی']),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPodcastEpisodes::route('/'),
            'create' => Pages\CreatePodcastEpisode::route('/create'),
            'edit' => Pages\EditPodcastEpisode::route('/{record}/edit'),
        ];
    }
}
