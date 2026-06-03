<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\HtmlString;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ── افزایش موجودی ──
            Action::make('wallet_add')
                ->label('افزایش موجودی')
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->modalHeading(fn () => 'افزایش موجودی — ' . $this->record->name)
                ->modalDescription(fn () => 'موجودی فعلی: ' . number_format((int) $this->record->getOrCreateWallet()->balance) . ' تومان')
                ->form([
                    TextInput::make('amount')
                        ->label('مبلغ (تومان)')
                        ->numeric()->required()->minValue(1)
                        ->suffix('تومان'),
                    Textarea::make('note')
                        ->label('توضیح')
                        ->placeholder('مثلاً: جبران خرابی، هدیه، ...')
                        ->rows(2),
                ])
                ->action(function (array $data) {
                    $wallet = $this->record->getOrCreateWallet();
                    $wallet->increment('balance', (int)$data['amount']);
                    $wallet->transactions()->create([
                        'type'          => 'deposit',
                        'amount'        => (int)$data['amount'],
                        'balance_after' => $wallet->fresh()->balance,
                        'description'   => 'شارژ دستی توسط ادمین' . ($data['note'] ? ': ' . $data['note'] : ''),
                        'status'        => 'approved',
                    ]);
                    Notification::make()->title('موجودی افزایش یافت')->success()->send();
                }),

            // ── کاهش موجودی ──
            Action::make('wallet_deduct')
                ->label('کاهش موجودی')
                ->icon('heroicon-o-minus-circle')
                ->color('danger')
                ->modalHeading(fn () => 'کاهش موجودی — ' . $this->record->name)
                ->modalDescription(fn () => 'موجودی فعلی: ' . number_format((int) $this->record->getOrCreateWallet()->balance) . ' تومان')
                ->form([
                    TextInput::make('amount')
                        ->label('مبلغ (تومان)')
                        ->numeric()->required()->minValue(1)
                        ->suffix('تومان'),
                    Textarea::make('note')
                        ->label('توضیح')
                        ->rows(2),
                ])
                ->action(function (array $data) {
                    $wallet = $this->record->getOrCreateWallet();
                    $amount = min((int)$data['amount'], (int)$wallet->balance);
                    if ($amount <= 0) {
                        Notification::make()->title('موجودی کافی نیست')->danger()->send();
                        return;
                    }
                    $wallet->decrement('balance', $amount);
                    $wallet->transactions()->create([
                        'type'          => 'withdrawal',
                        'amount'        => $amount,
                        'balance_after' => $wallet->fresh()->balance,
                        'description'   => 'کسر دستی توسط ادمین' . ($data['note'] ? ': ' . $data['note'] : ''),
                        'status'        => 'approved',
                    ]);
                    Notification::make()->title('موجودی کاهش یافت')->warning()->send();
                }),

            // ── تاریخچه کیف پول ──
            Action::make('wallet_history')
                ->label('تاریخچه کیف پول')
                ->icon('heroicon-o-banknotes')
                ->color('info')
                ->modalHeading(fn () => 'کیف پول — ' . $this->record->name)
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('بستن')
                ->modalWidth('4xl')
                ->form(function () {
                    $wallet  = $this->record->getOrCreateWallet();
                    $txs     = $wallet->transactions()->latest()->limit(50)->get();
                    $balance = number_format((int)$wallet->balance);

                    $typeMap = [
                        'deposit'    => ['label' => 'شارژ',         'bg' => '#d1fae5', 'color' => '#065f46'],
                        'withdrawal' => ['label' => 'برداشت',       'bg' => '#fee2e2', 'color' => '#991b1b'],
                        'purchase'   => ['label' => 'خرید',         'bg' => '#dbeafe', 'color' => '#1e40af'],
                        'sale_income'=> ['label' => 'درآمد فروش',   'bg' => '#ede9fe', 'color' => '#5b21b6'],
                        'earning'    => ['label' => 'درآمد پخش',    'bg' => '#e0e7ff', 'color' => '#3730a3'],
                        'refund'     => ['label' => 'استرداد',      'bg' => '#fef3c7', 'color' => '#92400e'],
                    ];
                    $statusMap = [
                        'approved' => ['label' => 'تأیید', 'bg' => '#d1fae5', 'color' => '#065f46'],
                        'pending'  => ['label' => 'انتظار','bg' => '#fef3c7', 'color' => '#92400e'],
                        'rejected' => ['label' => 'رد',    'bg' => '#fee2e2', 'color' => '#991b1b'],
                    ];

                    $rows = '';
                    if ($txs->isEmpty()) {
                        $rows = '<tr><td colspan="6" style="padding:32px;text-align:center;color:#9ca3af;font-size:13px;">هیچ تراکنشی ثبت نشده است</td></tr>';
                    } else {
                        foreach ($txs as $tx) {
                            $t  = $typeMap[$tx->type]   ?? ['label' => $tx->type,            'bg' => '#f3f4f6', 'color' => '#374151'];
                            $st = $statusMap[$tx->status ?? 'approved'] ?? ['label' => $tx->status ?? '', 'bg' => '#f3f4f6', 'color' => '#374151'];
                            $isIncome = in_array($tx->type, ['deposit','sale_income','earning','refund']);
                            $sign     = $isIncome ? '+' : '-';
                            $amtColor = $isIncome ? '#059669' : '#dc2626';
                            $jalaliDate = \App\Helpers\Jalali::format($tx->created_at, 'Y/m/d') . ' ' . $tx->created_at->format('H:i');
                            $rows .= '<tr style="border-bottom:1px solid #f0f0f0;">'
                                . '<td style="padding:10px 12px;font-size:12px;color:#6b7280;white-space:nowrap;">' . $jalaliDate . '</td>'
                                . '<td style="padding:10px 12px;"><span style="font-size:11px;padding:2px 8px;border-radius:20px;background:' . $t['bg'] . ';color:' . $t['color'] . ';font-weight:600;">' . $t['label'] . '</span></td>'
                                . '<td style="padding:10px 12px;font-size:13px;font-weight:700;color:' . $amtColor . ';">' . $sign . number_format((int)$tx->amount) . ' ت</td>'
                                . '<td style="padding:10px 12px;font-size:12px;color:#6b7280;">' . number_format((int)$tx->balance_after) . ' ت</td>'
                                . '<td style="padding:10px 12px;"><span style="font-size:11px;padding:2px 6px;border-radius:20px;background:' . $st['bg'] . ';color:' . $st['color'] . ';">' . $st['label'] . '</span></td>'
                                . '<td style="padding:10px 12px;font-size:12px;color:#9ca3af;max-width:220px;">' . e($tx->description ?? '') . '</td>'
                                . '</tr>';
                        }
                    }

                    $html = '
                    <div style="font-family:inherit;">
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 20px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:12px;margin-bottom:20px;color:white;">
                            <div>
                                <p style="font-size:12px;opacity:.8;margin-bottom:4px;">موجودی فعلی</p>
                                <p style="font-size:26px;font-weight:700;">' . $balance . ' تومان</p>
                            </div>
                            <svg width="40" height="40" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24" opacity=".7"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18-3a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3m18-3V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6"/></svg>
                        </div>
                        <div style="overflow:auto;max-height:440px;border:1px solid #e5e7eb;border-radius:12px;">
                            <table style="width:100%;border-collapse:collapse;min-width:600px;text-align:right;">
                                <thead>
                                    <tr style="background:#f9fafb;border-bottom:2px solid #e5e7eb;position:sticky;top:0;">
                                        <th style="padding:10px 12px;font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;">تاریخ</th>
                                        <th style="padding:10px 12px;font-size:11px;font-weight:700;color:#6b7280;">نوع</th>
                                        <th style="padding:10px 12px;font-size:11px;font-weight:700;color:#6b7280;">مبلغ</th>
                                        <th style="padding:10px 12px;font-size:11px;font-weight:700;color:#6b7280;">موجودی بعد</th>
                                        <th style="padding:10px 12px;font-size:11px;font-weight:700;color:#6b7280;">وضعیت</th>
                                        <th style="padding:10px 12px;font-size:11px;font-weight:700;color:#6b7280;">توضیح</th>
                                    </tr>
                                </thead>
                                <tbody>' . $rows . '</tbody>
                            </table>
                        </div>
                    </div>';

                    return [
                        \Filament\Forms\Components\Placeholder::make('wallet_view')
                            ->hiddenLabel()
                            ->content(new HtmlString($html)),
                    ];
                }),

            Actions\DeleteAction::make(),
        ];
    }
}
