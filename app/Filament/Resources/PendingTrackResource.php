<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingTrackResource\Pages;
use App\Helpers\Jalali;
use App\Models\Track;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PendingTrackResource extends TrackResource
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clock';
    protected static string | \UnitEnum | null $navigationGroup = 'مدیریت موسیقی';
    protected static ?string $modelLabel = 'آهنگ در انتظار تایید';
    protected static ?string $pluralModelLabel = 'بررسی آهنگ‌های جدید';
    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('status', 'pending');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('کاور')->circular()->disk('public'),
                Tables\Columns\TextColumn::make('title')->label('عنوان')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('artist_name')->label('نام هنرمند (وارد شده)')->searchable(),
                Tables\Columns\TextColumn::make('owner')->label('ارسال کننده')
                    ->getStateUsing(fn ($record) => $record->artist ? "هنرمند: {$record->artist->display_name}" : ($record->user ? "کاربر: {$record->user->name}" : '-')),
                
                Tables\Columns\TextColumn::make('preview')->label('پخش و بررسی')
                    ->formatStateUsing(fn () => 'پخش فایل')
                    ->view('filament.columns.audio-player'),

                Tables\Columns\TextColumn::make('created_at')->label('تاریخ ارسال')
                    ->formatStateUsing(fn ($state) => $state ? Jalali::format($state, 'Y/m/d H:i') : '-')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\Action::make('approve')
                    ->label('تایید و انتشار')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function (Track $record) {
                        $record->update([
                            'status' => 'published',
                            'published_at' => now(),
                        ]);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('آهنگ با موفقیت تایید و منتشر شد.')
                            ->success()
                            ->send();
                    }),
                \Filament\Actions\EditAction::make()->label('ویرایش'),
                \Filament\Actions\DeleteAction::make()->label('حذف/رد'),
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
            'index' => Pages\ManagePendingTracks::route('/'),
        ];
    }
}
