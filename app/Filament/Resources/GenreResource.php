<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenreResource\Pages;
use App\Models\Genre;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-squares-2x2';
    protected static string | \UnitEnum | null $navigationGroup = 'محتوا';
    protected static ?string $modelLabel = 'ژانر';
    protected static ?string $pluralModelLabel = 'ژانرها';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('نام انگلیسی')->required(),
            Forms\Components\TextInput::make('name_fa')->label('نام فارسی')->required(),
            Forms\Components\TextInput::make('icon')->label('آیکون'),
            Forms\Components\ColorPicker::make('color')->label('رنگ'),
            Forms\Components\FileUpload::make('cover_image')->label('تصویر')->image()->directory('genres'),
            Forms\Components\TextInput::make('sort_order')->label('ترتیب')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('فعال')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('color')->label('رنگ'),
                Tables\Columns\TextColumn::make('name_fa')->label('نام فارسی')->searchable(),
                Tables\Columns\TextColumn::make('name')->label('نام انگلیسی')->searchable(),
                Tables\Columns\TextColumn::make('sort_order')->label('ترتیب')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('فعال')->boolean(),
            ])
            ->reorderable('sort_order')
            ->actions([\Filament\Actions\EditAction::make()])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGenres::route('/'),
            'create' => Pages\CreateGenre::route('/create'),
            'edit' => Pages\EditGenre::route('/{record}/edit'),
        ];
    }
}
