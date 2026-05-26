<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WalletTransactionResource\Pages;
use App\Models\WalletTransaction;
use App\Models\Wallet;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;

class WalletTransactionResource extends Resource
{
    protected static ?string $model = WalletTransaction::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';
    protected static string | \UnitEnum | null $navigationGroup = 'مالی';
    protected static ?string $modelLabel = 'تراکنش کیف پول';
    protected static ?string $pluralModelLabel = 'تراکنش‌های کیف پول';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wallet.user.name')
                    ->label('کاربر')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'deposit'    => 'شارژ',
                        'withdrawal' => 'برداشت',
                        'earning'    => 'درآمد',
                        'purchase'   => 'خرید',
                        default      => $state,
                    })
                    ->color(fn($state) => match($state) {
                        'deposit'    => 'success',
                        'withdrawal' => 'danger',
                        'earning'    => 'info',
                        'purchase'   => 'warning',
                        default      => 'gray',
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->label('مبلغ (تومان)')
                    ->formatStateUsing(fn($state) => number_format($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'pending'  => 'در انتظار',
                        'approved' => 'تایید شده',
                        'rejected' => 'رد شده',
                        default    => $state,
                    })
                    ->color(fn($state) => match($state) {
                        'pending'  => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default    => 'gray',
                    }),
                Tables\Columns\TextColumn::make('reference_number')
                    ->label('شماره پیگیری')->searchable(),
                Tables\Columns\TextColumn::make('card_number')
                    ->label('شماره کارت'),
                Tables\Columns\ImageColumn::make('receipt_image')
                    ->label('رسید')
                    ->disk('public')
                    ->height(48)
                    ->width(48)
                    ->extraImgAttributes(['class' => 'rounded object-cover cursor-pointer'])
                    ->url(fn($record) => $record->receipt_image ? asset('storage/' . $record->receipt_image) : null)
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('admin_note')
                    ->label('یادداشت ادمین')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->admin_note)
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ')->dateTime('Y/m/d H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'pending'  => 'در انتظار',
                        'approved' => 'تایید شده',
                        'rejected' => 'رد شده',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع')
                    ->options([
                        'deposit'    => 'شارژ',
                        'withdrawal' => 'برداشت',
                    ]),
            ])
            ->actions([
                Action::make('view_detail')
                    ->label('جزئیات')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalHeading('جزئیات تراکنش')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('بستن')
                    ->form(fn($record) => [
                        Placeholder::make('user_info')
                            ->label('کاربر')
                            ->content(fn() => $record->wallet?->user?->name . ' — ' . $record->wallet?->user?->email),
                        Placeholder::make('amount_info')
                            ->label('مبلغ')
                            ->content(fn() => number_format((int)$record->amount) . ' تومان'),
                        Placeholder::make('type_info')
                            ->label('نوع')
                            ->content(fn() => match($record->type) {
                                'deposit' => 'شارژ کیف پول',
                                'withdrawal' => 'برداشت',
                                default => $record->type,
                            }),
                        Placeholder::make('status_info')
                            ->label('وضعیت')
                            ->content(fn() => match($record->status) {
                                'pending' => '⏳ در انتظار',
                                'approved' => '✅ تایید شده',
                                'rejected' => '❌ رد شده',
                                default => $record->status,
                            }),
                        Placeholder::make('reference_info')
                            ->label('شماره پیگیری')
                            ->content(fn() => $record->reference_number ?? '—'),
                        Placeholder::make('card_info')
                            ->label('شماره کارت پرداختی')
                            ->content(fn() => $record->card_number ?? '—'),
                        Placeholder::make('admin_note_info')
                            ->label('یادداشت ادمین / دلیل رد')
                            ->content(fn() => $record->admin_note ?? '—'),
                        Placeholder::make('receipt_preview')
                            ->label('تصویر رسید')
                            ->content(fn() => $record->receipt_image
                                ? new HtmlString('<a href="' . asset('storage/' . $record->receipt_image) . '" target="_blank"><img src="' . asset('storage/' . $record->receipt_image) . '" class="max-h-80 rounded-lg border mt-1 hover:opacity-90 transition" /></a>')
                                : new HtmlString('<span class="text-gray-400">رسیدی آپلود نشده</span>')),
                    ]),

                Action::make('approve')
                    ->label('تایید')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('تایید تراکنش')
                    ->modalDescription('با تایید این تراکنش، موجودی کیف پول کاربر به‌روز می‌شود.')
                    ->form([
                        Textarea::make('admin_note')->label('یادداشت (اختیاری)')->rows(2),
                    ])
                    ->action(function ($record, array $data) {
                        $wallet = $record->wallet;
                        if ($record->type === 'deposit') {
                            $wallet->increment('balance', $record->amount);
                            $record->update([
                                'status'        => 'approved',
                                'balance_after' => $wallet->balance,
                                'admin_note'    => $data['admin_note'] ?? null,
                                'reviewed_by'   => auth()->id(),
                                'reviewed_at'   => now(),
                            ]);
                        } else {
                            $record->update([
                                'status'      => 'approved',
                                'admin_note'  => $data['admin_note'] ?? null,
                                'reviewed_by' => auth()->id(),
                                'reviewed_at' => now(),
                            ]);
                        }
                        Notification::make()->title('تراکنش تایید شد')->success()->send();
                    }),

                Action::make('reject')
                    ->label('رد')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('رد تراکنش')
                    ->form([
                        Textarea::make('admin_note')->label('دلیل رد')->required()->rows(2),
                    ])
                    ->action(function ($record, array $data) {
                        $wallet = $record->wallet;
                        if ($record->type === 'withdrawal') {
                            $wallet->increment('balance', $record->amount);
                        }
                        $record->update([
                            'status'      => 'rejected',
                            'admin_note'  => $data['admin_note'],
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                        ]);
                        Notification::make()->title('تراکنش رد شد')->danger()->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWalletTransactions::route('/'),
        ];
    }
}
