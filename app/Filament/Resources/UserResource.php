<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';
    protected static string | \UnitEnum | null $navigationGroup = 'مدیریت کاربران';
    protected static ?string $modelLabel = 'کاربر';
    protected static ?string $pluralModelLabel = 'کاربران';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات اصلی')->schema([
                Forms\Components\TextInput::make('name')->label('نام')->required()->maxLength(255),
                Forms\Components\TextInput::make('username')->label('نام کاربری')->maxLength(255),
                Forms\Components\TextInput::make('email')->label('ایمیل')->email()->maxLength(255),
                Forms\Components\TextInput::make('phone')->label('موبایل')->tel()->maxLength(15),
                Forms\Components\Select::make('type')->label('نوع')
                    ->options(['listener' => 'شنونده', 'artist' => 'هنرمند', 'admin' => 'مدیر', 'moderator' => 'ناظر'])
                    ->required(),
                Forms\Components\Select::make('gender')->label('جنسیت')
                    ->options(['male' => 'مرد', 'female' => 'زن', 'other' => 'سایر']),
                \App\Filament\Forms\Components\JalaliDatePicker::make('birth_date')->label('تاریخ تولد'),
                Forms\Components\TextInput::make('country')->label('کشور')->default('IR'),
                Forms\Components\TextInput::make('city')->label('شهر'),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('وضعیت')->schema([
                Forms\Components\Toggle::make('is_active')->label('فعال')->default(true),
                Forms\Components\Toggle::make('is_premium')->label('پریمیوم'),
                \App\Filament\Forms\Components\JalaliDatePicker::make('premium_expires_at')->label('انقضای پریمیوم'),
            ])->columns(3),

            \Filament\Schemas\Components\Section::make('بیوگرافی')->schema([
                Forms\Components\Textarea::make('bio')->label('بیو')->rows(3),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->label('آواتار')->circular()->disk('public')->defaultImageUrl(asset('images/default-avatar.png')),
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('نام')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->label('موبایل')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('ایمیل')->searchable(),
                Tables\Columns\BadgeColumn::make('type')->label('نوع')
                    ->colors(['primary' => 'listener', 'success' => 'artist', 'danger' => 'admin', 'warning' => 'moderator']),
                Tables\Columns\IconColumn::make('is_active')->label('فعال')->boolean(),
                Tables\Columns\IconColumn::make('is_premium')->label('پریمیوم')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('تاریخ ثبت')->dateTime('Y/m/d')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->label('نوع')
                    ->options(['listener' => 'شنونده', 'artist' => 'هنرمند', 'admin' => 'مدیر', 'moderator' => 'ناظر']),
                Tables\Filters\TernaryFilter::make('is_active')->label('فعال'),
                Tables\Filters\TernaryFilter::make('is_premium')->label('پریمیوم'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
