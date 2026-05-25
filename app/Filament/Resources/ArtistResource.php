<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtistResource\Pages;
use App\Models\Artist;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ArtistResource extends Resource
{
    protected static ?string $model = Artist::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-microphone';
    protected static string | \UnitEnum | null $navigationGroup = 'مدیریت کاربران';
    protected static ?string $modelLabel = 'هنرمند';
    protected static ?string $pluralModelLabel = 'هنرمندان';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات هنرمند')->schema([
                Forms\Components\Select::make('user_id')->label('کاربر')
                    ->relationship('user', 'name')->required()->searchable()->preload(),
                Forms\Components\TextInput::make('display_name')->label('نام نمایشی')->required(),
                Forms\Components\Textarea::make('bio')->label('بیوگرافی')->rows(3),
                Forms\Components\FileUpload::make('cover_image')->label('تصویر کاور')->image()->directory('artists')->disk('public')->visibility('public'),
            ])->columns(2),
            \Filament\Schemas\Components\Section::make('شبکه‌های اجتماعی')->schema([
                Forms\Components\TextInput::make('website')->label('وبسایت')->url(),
                Forms\Components\TextInput::make('instagram')->label('اینستاگرام'),
                Forms\Components\TextInput::make('twitter')->label('توییتر'),
                Forms\Components\TextInput::make('telegram')->label('تلگرام'),
            ])->columns(2),
            \Filament\Schemas\Components\Section::make('تأیید و وضعیت')->schema([
                Forms\Components\Select::make('verification_status')->label('وضعیت تأیید')
                    ->options(['pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده'])->required(),
                Forms\Components\DateTimePicker::make('verified_at')->label('تاریخ تأیید'),
                Forms\Components\Toggle::make('is_featured')->label('ویژه'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('تصویر')->circular()->disk('public')->defaultImageUrl(asset('images/default-avatar.png')),
                Tables\Columns\TextColumn::make('display_name')->label('نام')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('کاربر'),
                Tables\Columns\BadgeColumn::make('verification_status')->label('تأیید')
                    ->colors(['warning' => 'pending', 'success' => 'approved', 'danger' => 'rejected']),
                Tables\Columns\TextColumn::make('followers_count')->label('دنبال‌کننده')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('total_streams')->label('کل پخش')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label('ویژه')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('verification_status')->label('وضعیت تأیید')
                    ->options(['pending' => 'در انتظار', 'approved' => 'تأیید شده', 'rejected' => 'رد شده']),
            ])
            ->actions([\Filament\Actions\EditAction::make()])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArtists::route('/'),
            'create' => Pages\CreateArtist::route('/create'),
            'edit' => Pages\EditArtist::route('/{record}/edit'),
        ];
    }
}
