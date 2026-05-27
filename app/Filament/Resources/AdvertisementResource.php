<?php

namespace App\Filament\Resources;

use App\Models\Advertisement;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Forms\Components\JalaliDatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;

class AdvertisementResource extends Resource
{
    protected static ?string $model = Advertisement::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-megaphone';
    protected static string|\UnitEnum|null $navigationGroup = 'سیستم';
    protected static ?string $modelLabel = 'تبلیغ';
    protected static ?string $pluralModelLabel = 'تبلیغات';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('اطلاعات تبلیغ')->schema([
                TextInput::make('title')
                    ->label('عنوان')
                    ->required(),
                Select::make('type')
                    ->label('نوع')
                    ->options([
                        'audio'  => 'صوتی (بین آهنگ‌ها)',
                        'banner' => 'بنر',
                    ])
                    ->default('audio')
                    ->reactive()
                    ->required(),
                Select::make('status')
                    ->label('وضعیت')
                    ->options([
                        'draft'  => 'پیش‌نویس',
                        'active' => 'فعال',
                        'paused' => 'متوقف',
                    ])
                    ->default('draft')
                    ->required(),
                TextInput::make('priority')
                    ->label('اولویت')
                    ->numeric()
                    ->default(0)
                    ->helperText('عدد بالاتر = اولویت بیشتر'),
            ])->columns(2),

            Section::make('فایل صوتی')->schema([
                FileUpload::make('audio_media_path')
                    ->label('فایل صوتی آگهی')
                    ->disk('public')
                    ->directory('ads/audio')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg'])
                    ->maxSize(10240)
                    ->columnSpanFull(),
                TextInput::make('audio_media_url')
                    ->label('یا URL فایل صوتی')
                    ->url()
                    ->helperText('اگر فایل آپلود نشده، از URL استفاده کنید')
                    ->columnSpanFull(),
                TextInput::make('duration')
                    ->label('مدت زمان (ثانیه)')
                    ->numeric()
                    ->default(15),
            ])->columns(2)
            ->visible(fn ($get) => $get('type') === 'audio'),

            Section::make('تصویر بنر')->schema([
                FileUpload::make('banner_media_path')
                    ->label('تصویر بنر')
                    ->disk('public')
                    ->directory('ads/banners')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048)
                    ->columnSpanFull(),
                TextInput::make('banner_media_url')
                    ->label('یا URL تصویر')
                    ->url()
                    ->helperText('اگر فایل آپلود نشده، از URL استفاده کنید')
                    ->columnSpanFull(),
            ])->columns(2)
            ->visible(fn ($get) => $get('type') === 'banner'),

            Section::make('تنظیمات نمایش')->schema([
                TextInput::make('tracks_between')
                    ->label('هر چند آهنگ یک بار')
                    ->numeric()
                    ->default(3)
                    ->helperText('مثلاً 3 = بعد از هر 3 آهنگ'),
            ])->columns(2),

            Section::make('هدف‌گذاری')->schema([
                Select::make('target_plans')
                    ->label('نمایش برای پلن‌ها')
                    ->multiple()
                    ->options(function () {
                        $plans = \App\Models\Plan::all()->pluck('name', 'slug');
                        return ['all' => 'همه', 'free' => 'رایگان'] + $plans->toArray();
                    })
                    ->default(['free'])
                    ->helperText('خالی = همه کاربران')
                    ->columnSpanFull(),
                JalaliDatePicker::make('starts_at')
                    ->label('شروع از')
                    ->default(fn() => \App\Helpers\Jalali::format(now(), 'Y/m/d')),
                JalaliDatePicker::make('ends_at')
                    ->label('پایان در')
                    ->nullable(),
                TextInput::make('max_impressions')
                    ->label('حداکثر نمایش')
                    ->numeric()
                    ->nullable()
                    ->helperText('خالی = بدون محدودیت'),
            ])->columns(2),

            Section::make('دکمه/لینک')->schema([
                TextInput::make('button_text')
                    ->label('متن دکمه')
                    ->placeholder('مثال: خرید اشتراک')
                    ->columnSpanFull(),
                TextInput::make('button_url')
                    ->label('لینک دکمه')
                    ->url()
                    ->placeholder('https://example.com')
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('توضیحات')->schema([
                Textarea::make('description')
                    ->label('توضیحات')
                    ->rows(2)
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable(),
                Tables\Columns\TextColumn::make('impressions')->label('نمایش')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('duration')->label('مدت (ثانیه)'),
                Tables\Columns\TextColumn::make('tracks_between')->label('هر N آهنگ'),
                Tables\Columns\TextColumn::make('starts_at')->label('شروع')
                    ->formatStateUsing(fn($state) => $state ? \App\Helpers\Jalali::format($state, 'Y/m/d') : '—')
                    ->sortable(),
            ])
            ->defaultSort('priority', 'desc')
            ->actions([
                EditAction::make()->label('ویرایش'),
                DeleteAction::make()->label('حذف'),
            ])
            ->bulkActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => \App\Filament\Resources\AdvertisementResource\Pages\ListAdvertisements::route('/'),
            'create' => \App\Filament\Resources\AdvertisementResource\Pages\CreateAdvertisement::route('/create'),
            'edit'   => \App\Filament\Resources\AdvertisementResource\Pages\EditAdvertisement::route('/{record}/edit'),
        ];
    }
}
