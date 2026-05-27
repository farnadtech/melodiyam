<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtistSubscriptionResource\Pages;
use App\Helpers\Jalali;
use App\Models\ArtistSubscription;
use App\Models\ArtistPlan;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ArtistSubscriptionResource extends Resource
{
    protected static ?string $model = ArtistSubscription::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';
    protected static string|\UnitEnum|null $navigationGroup = 'مدیریت';
    protected static ?string $modelLabel = 'اشتراک هنرمند';
    protected static ?string $pluralModelLabel = 'اشتراک‌های هنرمند';
    protected static ?int $navigationSort = 7;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'active')
            ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->count();
        return $count > 0 ? (string)$count : null;
    }

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            \Filament\Schemas\Components\Section::make('اطلاعات اشتراک')->schema([
                Forms\Components\Select::make('artist_id')
                    ->label('هنرمند')
                    ->relationship('artist', 'display_name')
                    ->searchable()->preload()->required(),
                Forms\Components\Select::make('plan_id')
                    ->label('پلن')
                    ->options(ArtistPlan::where('is_active', true)->pluck('name', 'id'))
                    ->required()->live()
                    ->afterStateUpdated(function ($state, $set) {
                        $plan = ArtistPlan::find($state);
                        if ($plan) {
                            $set('expires_at', now()->addDays($plan->duration_days)->format('Y-m-d H:i:s'));
                        }
                    }),
                Forms\Components\Select::make('status')
                    ->label('وضعیت')
                    ->options(ArtistSubscription::$statuses)
                    ->required()->default('active'),
                \App\Filament\Forms\Components\JalaliDatePicker::make('starts_at')
                    ->label('شروع')->required()->default(now()),
                \App\Filament\Forms\Components\JalaliDatePicker::make('expires_at')
                    ->label('انقضا')->nullable(),
                Forms\Components\TextInput::make('payment_ref')
                    ->label('شماره پرداخت')->nullable(),
            ])->columns(2),

            \Filament\Schemas\Components\Section::make('مصرف')->schema([
                Forms\Components\TextInput::make('tracks_used')
                    ->label('آهنگ آپلودشده')->numeric()->default(0),
                Forms\Components\TextInput::make('albums_used')
                    ->label('آلبوم آپلودشده')->numeric()->default(0),
                Forms\Components\TextInput::make('storage_used_mb')
                    ->label('فضای مصرفی (MB)')->numeric()->default(0)->suffix('MB'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('artist.display_name')
                    ->label('هنرمند')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('plan.name')
                    ->label('پلن')->badge()->color('primary'),
                Tables\Columns\TextColumn::make('status')->label('وضعیت')
                    ->badge()
                    ->formatStateUsing(fn($state) => ArtistSubscription::$statuses[$state] ?? $state)
                    ->color(fn($state) => match($state) {
                        'active'    => 'success',
                        'expired'   => 'danger',
                        'cancelled' => 'gray',
                        default     => 'gray',
                    }),
                Tables\Columns\TextColumn::make('starts_at')->label('شروع')
                    ->formatStateUsing(fn($state) => $state ? Jalali::format($state, 'Y/m/d') : '-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')->label('انقضا')
                    ->formatStateUsing(fn($state) => $state ? Jalali::format($state, 'Y/m/d') : 'نامحدود')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tracks_used')->label('آهنگ‌ها')->numeric(),
                Tables\Columns\TextColumn::make('albums_used')->label('آلبوم‌ها')->numeric(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')->options(ArtistSubscription::$statuses),
                Tables\Filters\SelectFilter::make('plan_id')
                    ->label('پلن')->relationship('plan', 'name'),
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
            'index'  => Pages\ListArtistSubscriptions::route('/'),
            'create' => Pages\CreateArtistSubscription::route('/create'),
            'edit'   => Pages\EditArtistSubscription::route('/{record}/edit'),
        ];
    }
}
