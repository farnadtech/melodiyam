<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlbumResource\Pages;
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

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات آلبوم')->schema([
                Forms\Components\Select::make('artist_id')->label('هنرمند')
                    ->relationship('artist', 'display_name')->required()->searchable()->preload(),
                Forms\Components\Select::make('genre_id')->label('ژانر')
                    ->relationship('genre', 'name_fa')->searchable()->preload(),
                Forms\Components\TextInput::make('title')->label('عنوان فارسی')->required(),
                Forms\Components\TextInput::make('title_en')->label('عنوان انگلیسی'),
                Forms\Components\Select::make('type')->label('نوع')
                    ->options(['album' => 'آلبوم', 'single' => 'سینگل', 'ep' => 'EP', 'compilation' => 'کامپایل'])->required(),
                Forms\Components\Textarea::make('description')->label('توضیحات')->rows(2),
                Forms\Components\FileUpload::make('cover_image')->label('تصویر کاور')->image()->directory('albums')->disk('public')->visibility('public'),
                Forms\Components\DatePicker::make('release_date')->label('تاریخ ریلیز'),
            ])->columns(2),
            \Filament\Schemas\Components\Section::make('وضعیت')->schema([
                Forms\Components\Select::make('status')->label('وضعیت')
                    ->options(['draft' => 'پیش‌نویس', 'published' => 'منتشر', 'archived' => 'بایگانی'])->required(),
                Forms\Components\Toggle::make('is_explicit')->label('نامناسب'),
                Forms\Components\Toggle::make('is_featured')->label('ویژه'),
                Forms\Components\TextInput::make('upc')->label('UPC'),
                Forms\Components\TextInput::make('copyright')->label('کپی‌رایت'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('کاور')->circular(),
                Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('artist.display_name')->label('هنرمند')->searchable(),
                Tables\Columns\BadgeColumn::make('type')->label('نوع'),
                Tables\Columns\BadgeColumn::make('status')->label('وضعیت')
                    ->colors(['gray' => 'draft', 'success' => 'published', 'danger' => 'archived']),
                Tables\Columns\TextColumn::make('play_count')->label('پخش')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('release_date')->label('ریلیز')->date('Y/m/d')->sortable(),
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
