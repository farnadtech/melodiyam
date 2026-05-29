<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\JalaliDatePicker;
use App\Filament\Resources\PodcastResource\Pages;
use App\Helpers\Jalali;
use App\Models\Podcast;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PodcastResource extends Resource
{
    protected static ?string $model = Podcast::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-signal';
    protected static string | \UnitEnum | null $navigationGroup = 'محتوا';
    protected static ?string $modelLabel = 'پادکست';
    protected static ?string $pluralModelLabel = 'پادکست‌ها';
    protected static ?int $navigationSort = 5;

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
            \Filament\Schemas\Components\Section::make('اطلاعات پادکست')->schema([
                Forms\Components\Select::make('artist_id')->label('هنرمند/دی‌جی')
                    ->relationship('artist', 'display_name')
                    ->searchable()
                    ->preload()
                    ->helperText('اگر پادکست متعلق به یک هنرمند ثبت شده است، او را انتخاب کنید.'),
                Forms\Components\Select::make('user_id')->label('کاربر صاحب پادکست')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('کاربری که مدیریت این پادکست را بر عهده دارد.'),
                Forms\Components\TextInput::make('title')->label('عنوان پادکست')->required()->maxLength(255),
                Forms\Components\Textarea::make('description')->label('توضیحات')->rows(3),
                Forms\Components\Select::make('category')->label('دسته‌بندی')
                    ->options(\App\Models\Genre::active()->pluck('name_fa', 'name_fa'))
                    ->searchable()
                    ->placeholder('انتخاب دسته‌بندی'),
                Forms\Components\FileUpload::make('cover_image')->label('تصویر کاور')
                    ->image()->directory('podcasts/covers')->disk('public')->visibility('public'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('تنظیمات')->schema([
                Forms\Components\Select::make('language')->label('زبان')
                    ->options(['fa' => 'فارسی', 'en' => 'انگلیسی'])->default('fa'),
                Forms\Components\Toggle::make('is_explicit')->label('محتوای نامناسب'),
                Forms\Components\Toggle::make('is_featured')->label('ویژه (صفحه اصلی)')
                    ->default(false),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('وضعیت انتشار')->schema([
                Forms\Components\Select::make('status')->label('وضعیت')
                    ->options([
                        'draft' => 'پیش‌نویس',
                        'pending' => 'در انتظار تایید',
                        'published' => 'منتشر شده',
                        'archived' => 'بایگانی'
                    ])
                    ->required()->default('draft'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('کاور')->circular()->disk('public'),
                Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('artist.display_name')->label('هنرمند')->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('کاربر'),
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
                Tables\Columns\TextColumn::make('subscribers_count')->label('مشترکین')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('تاریخ ایجاد')
                    ->formatStateUsing(fn ($state) => $state ? Jalali::format($state, 'Y/m/d') : '-')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('وضعیت')
                    ->options(['draft' => 'پیش‌نویس', 'published' => 'منتشر', 'archived' => 'بایگانی']),
                Tables\Filters\SelectFilter::make('artist_id')->label('هنرمند')
                    ->relationship('artist', 'display_name')->searchable()->preload(),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // Episodes relation manager can be added here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPodcasts::route('/'),
            'create' => Pages\CreatePodcast::route('/create'),
            'edit' => Pages\EditPodcast::route('/{record}/edit'),
        ];
    }
}
