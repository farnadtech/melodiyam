<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Helpers\Jalali;
use App\Models\Page;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
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
            Section::make('جزئیات صفحه')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                
                Forms\Components\TextInput::make('slug')
                    ->label('اسلاگ (URL)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText(fn ($record) => $record ? 'آدرس نهایی: ' . url('/p/' . $record->slug) : 'بعد از ذخیره، آدرس نهایی نمایش داده می‌شود.'),
                
                Tabs::make('محتوای صفحه')->tabs([
                    Tab::make('ویرایشگر بصری')->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('')
                            ->toolbarButtons([
                                'attachFiles', 'blockquote', 'bold', 'bulletList', 'codeBlock', 'h2', 'h3', 'italic', 'link', 'orderedList', 'redo', 'strike', 'undo',
                            ]),
                    ]),
                    Tab::make('کد HTML')->schema([
                        Forms\Components\Textarea::make('content')
                            ->label('')
                            ->rows(15)
                            ->extraAttributes(['style' => 'font-family: monospace;'])
                            ->helperText('کدهای HTML خود را اینجا وارد کنید. تغییرات در هر دو لبه همگام‌سازی می‌شود.')
                            ->live(onBlur: true),
                    ]),
                ])->columnSpanFull(),
                
                Forms\Components\Toggle::make('is_published')
                    ->label('منتشر شده')
                    ->default(true),
            ])->columns(2),

            Section::make('سئو (SEO)')->schema([
                Forms\Components\TextInput::make('seo_title')->label('عنوان SEO'),
                Forms\Components\Textarea::make('seo_description')->label('توضیحات SEO')->rows(2),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('اسلاگ'),
                Tables\Columns\IconColumn::make('is_published')->label('منتشر')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخرین ویرایش')
                    ->formatStateUsing(fn ($state) => $state ? Jalali::format($state, 'Y/m/d H:i') : '-')
                    ->sortable(),
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
