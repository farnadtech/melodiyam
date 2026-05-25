<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    protected static string | \UnitEnum | null $navigationGroup = 'محتوا';
    protected static ?string $modelLabel = 'صفحه';
    protected static ?string $pluralModelLabel = 'صفحات';
    protected static ?int $navigationSort = 10;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('عنوان')->required(),
            Forms\Components\RichEditor::make('content')->label('محتوا')->required()->columnSpanFull(),
            Forms\Components\Toggle::make('is_published')->label('منتشر شده')->default(true),
            Forms\Components\TextInput::make('seo_title')->label('عنوان SEO'),
            Forms\Components\Textarea::make('seo_description')->label('توضیحات SEO')->rows(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('اسلاگ'),
                Tables\Columns\IconColumn::make('is_published')->label('منتشر')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->label('آخرین ویرایش')->dateTime('Y/m/d'),
            ])
            ->actions([\Filament\Actions\EditAction::make()])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
