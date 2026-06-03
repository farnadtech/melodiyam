<?php

namespace App\Filament\Resources\Payments;

use App\Filament\Resources\Payments\Pages;
use App\Models\Payment;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-credit-card';
    protected static string|\UnitEnum|null   $navigationGroup = 'مالی و اشتراک‌ها';
    protected static ?string $modelLabel         = 'تراکنش درگاه';
    protected static ?string $pluralModelLabel   = 'تراکنش‌های درگاه پرداخت';
    protected static ?int    $navigationSort      = 4;

    public static function getNavigationBadge(): ?string
    {
        $failed = static::getModel()::where('status', 'failed')->count();
        return $failed ? (string) $failed : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')->sortable()->width('60px'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('کاربر')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('payment_type')
                    ->label('نوع پرداخت')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'subscription'        => 'اشتراک کاربر',
                        'artist_subscription' => 'اشتراک هنرمند',
                        'wallet_deposit'      => 'شارژ کیف پول',
                        default               => $state,
                    })
                    ->color(fn($state) => match($state) {
                        'subscription'        => 'primary',
                        'artist_subscription' => 'warning',
                        'wallet_deposit'      => 'success',
                        default               => 'gray',
                    }),

                Tables\Columns\TextColumn::make('gateway')
                    ->label('درگاه')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'zarinpal' => 'زرین‌پال',
                        'zibal'    => 'زیبال',
                        'payping'  => 'پی‌پینگ',
                        default    => $state,
                    })
                    ->color('info'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('مبلغ (تومان)')
                    ->formatStateUsing(fn($record) => number_format((int)$record->amount + (int)$record->tax_amount + (int)$record->fee_amount))
                    ->description(fn($record) => $record->tax_amount > 0
                        ? 'مالیات: ' . number_format($record->tax_amount) . ' ت'
                        : null)
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->formatStateUsing(fn($state) => match($state) {
                        'pending'  => 'در انتظار',
                        'paid'     => 'پرداخت شده',
                        'failed'   => 'ناموفق',
                        'refunded' => 'مسترد',
                        default    => $state,
                    })
                    ->color(fn($state) => match($state) {
                        'pending'  => 'warning',
                        'paid'     => 'success',
                        'failed'   => 'danger',
                        'refunded' => 'gray',
                        default    => 'gray',
                    }),

                Tables\Columns\TextColumn::make('ref_id')
                    ->label('کد پیگیری')
                    ->copyable()
                    ->copyMessage('کپی شد')
                    ->placeholder('—')
                    ->searchable(),

                Tables\Columns\TextColumn::make('authority')
                    ->label('Authority')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->authority)
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('description')
                    ->label('توضیحات')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->description),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ')->dateTime('Y/m/d H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'pending'  => 'در انتظار',
                        'paid'     => 'پرداخت شده',
                        'failed'   => 'ناموفق',
                        'refunded' => 'مسترد',
                    ]),

                Tables\Filters\SelectFilter::make('gateway')
                    ->label('درگاه')
                    ->options([
                        'zarinpal' => 'زرین‌پال',
                        'zibal'    => 'زیبال',
                        'payping'  => 'پی‌پینگ',
                    ]),

                Tables\Filters\SelectFilter::make('payment_type')
                    ->label('نوع')
                    ->options([
                        'subscription'        => 'اشتراک کاربر',
                        'artist_subscription' => 'اشتراک هنرمند',
                        'wallet_deposit'      => 'شارژ کیف پول',
                    ]),

                Tables\Filters\Filter::make('date_range')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('از تاریخ'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('تا تاریخ'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'],  fn($q, $d) => $q->whereDate('created_at', '>=', $d))
                            ->when($data['until'], fn($q, $d) => $q->whereDate('created_at', '<=', $d));
                    }),
            ])
            ->actions([
                Action::make('view_detail')
                    ->label('جزئیات')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalHeading('جزئیات تراکنش درگاه')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('بستن')
                    ->form(fn($record) => [
                        Placeholder::make('user_info')
                            ->label('کاربر')
                            ->content(fn() => ($record->user->name ?? '—') . ' — ' . ($record->user->email ?? '') . ($record->user->phone ? ' — ' . $record->user->phone : '')),

                        Placeholder::make('type_info')
                            ->label('نوع پرداخت')
                            ->content(fn() => $record->typeLabel()),

                        Placeholder::make('gateway_info')
                            ->label('درگاه')
                            ->content(fn() => $record->gatewayLabel()),

                        Placeholder::make('amount_info')
                            ->label('مبلغ پرداختی')
                            ->content(fn() => number_format((int)$record->amount + (int)$record->tax_amount + (int)$record->fee_amount) . ' تومان'
                                . ($record->tax_amount > 0 ? ' (مالیات: ' . number_format($record->tax_amount) . ' ت)' : '')),

                        Placeholder::make('status_info')
                            ->label('وضعیت')
                            ->content(fn() => $record->statusLabel()),

                        Placeholder::make('authority_info')
                            ->label('Authority / Track ID')
                            ->content(fn() => $record->authority ?? '—'),

                        Placeholder::make('ref_id_info')
                            ->label('کد پیگیری (Ref ID)')
                            ->content(fn() => $record->ref_id ?? '—'),

                        Placeholder::make('description_info')
                            ->label('توضیحات')
                            ->content(fn() => $record->description ?? '—'),

                        Placeholder::make('gateway_response_info')
                            ->label('پاسخ کامل درگاه')
                            ->content(fn() => new HtmlString(
                                '<pre class="text-xs text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900 p-3 rounded-lg overflow-auto max-h-64 leading-relaxed">'
                                . htmlspecialchars(json_encode($record->gateway_response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
                                . '</pre>'
                            )),
                    ]),

                Action::make('refund')
                    ->label('استرداد')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('warning')
                    ->visible(fn($record) => $record->status === 'paid')
                    ->requiresConfirmation()
                    ->modalHeading('ثبت استرداد')
                    ->modalDescription('این عملیات فقط وضعیت را «مسترد» می‌کند. بازگشت وجه باید از پنل درگاه انجام شود.')
                    ->action(function ($record) {
                        $record->update(['status' => 'refunded']);
                        Notification::make()->title('تراکنش مسترد شد')->warning()->send();
                    }),
            ])
            ->bulkActions([])
            ->headerActions([
                // Stats summary
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }
}
