<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function index(): View
    {
        $user    = auth()->user();
        $wallet  = $user->getOrCreateWallet();
        $transactions = $wallet->transactions()->latest()->paginate(15);

        $settings = Setting::getAll();
        $walletEnabled    = ($settings['wallet_enabled']    ?? '1') !== '0';
        $card2cardEnabled = ($settings['card2card_enabled'] ?? '1') !== '0';
        $gatewayEnabled   = !empty($settings['payment_gateway']);
        $bankCardNumber   = $settings['bank_card_number']  ?? '';
        $bankCardOwner    = $settings['bank_card_owner']   ?? '';
        $depositMin       = (int)($settings['deposit_min_amount']      ?? 10000);
        $depositMax       = (int)($settings['deposit_max_amount']      ?? 50000000);
        $withdrawMin      = (int)($settings['withdraw_min_amount']     ?? 10000);
        $withdrawMax      = (int)($settings['withdraw_max_amount']     ?? 10000000);
        $taxPercent       = (float)($settings['transaction_tax_percent'] ?? 0);
        $withdrawFee      = (int)($settings['withdraw_fee_amount']     ?? 0);

        return view('library.wallet', compact(
            'wallet', 'transactions',
            'walletEnabled', 'card2cardEnabled', 'gatewayEnabled',
            'bankCardNumber', 'bankCardOwner',
            'depositMin', 'depositMax', 'withdrawMin', 'withdrawMax',
            'taxPercent', 'withdrawFee'
        ));
    }

    public function depositRequest(Request $request)
    {
        $settings = Setting::getAll();
        if (($settings['wallet_enabled'] ?? '1') === '0') {
            return back()->with('error', 'کیف پول غیرفعال است.');
        }
        if (($settings['card2card_enabled'] ?? '1') === '0') {
            return back()->with('error', 'شارژ کارت به کارت غیرفعال است.');
        }

        $depositMin = (int)($settings['deposit_min_amount'] ?? 10000);
        $depositMax = (int)($settings['deposit_max_amount'] ?? 50000000);

        $validated = $request->validate([
            'amount'           => "required|integer|min:{$depositMin}|max:{$depositMax}",
            'card_number'      => 'required|string|max:20',
            'reference_number' => 'required|string|max:50',
            'receipt_image'    => 'required|image|max:3072',
        ], [
            'amount.min'       => 'حداقل مبلغ ' . number_format($depositMin) . ' تومان است.',
            'amount.max'       => 'حداکثر مبلغ ' . number_format($depositMax) . ' تومان است.',
            'receipt_image.required' => 'تصویر رسید الزامی است.',
        ]);

        $wallet = auth()->user()->getOrCreateWallet();

        $receiptPath = $request->file('receipt_image')->store('receipts', 'public');

        $wallet->transactions()->create([
            'type'             => 'deposit',
            'amount'           => $validated['amount'],
            'balance_after'    => $wallet->balance, // موجودی قبل از تایید
            'description'      => 'شارژ کیف پول - کارت به کارت',
            'status'           => 'pending',
            'card_number'      => $validated['card_number'],
            'reference_number' => $validated['reference_number'],
            'receipt_image'    => $receiptPath,
        ]);

        return back()->with('success', 'درخواست شارژ ثبت شد. پس از تایید توسط ادمین، موجودی افزایش می‌یابد.');
    }

    public function withdrawRequest(Request $request)
    {
        $settings = Setting::getAll();
        if (($settings['wallet_enabled'] ?? '1') === '0') {
            return back()->with('error', 'کیف پول غیرفعال است.');
        }

        $withdrawMin = (int)($settings['withdraw_min_amount'] ?? 10000);
        $withdrawMax = (int)($settings['withdraw_max_amount'] ?? 10000000);
        $withdrawFee = (int)($settings['withdraw_fee_amount'] ?? 0);
        $taxPercent  = (float)($settings['transaction_tax_percent'] ?? 0);

        $validated = $request->validate([
            'amount'      => "required|integer|min:{$withdrawMin}|max:{$withdrawMax}",
            'card_number' => 'required|string|size:16',
            'card_owner'  => 'required|string|max:100',
        ], [
            'amount.min'       => 'حداقل مبلغ برداشت ' . number_format($withdrawMin) . ' تومان است.',
            'amount.max'       => 'حداکثر مبلغ برداشت ' . number_format($withdrawMax) . ' تومان است.',
            'card_number.size' => 'شماره کارت باید ۱۶ رقم باشد.',
        ]);

        $wallet = auth()->user()->getOrCreateWallet();

        // محاسبه کارمزد و مالیات
        $taxAmount   = (int)round($validated['amount'] * $taxPercent / 100);
        $totalDeduct = $validated['amount'] + $taxAmount + $withdrawFee;

        if ($wallet->balance < $totalDeduct) {
            return back()->with('error', 'موجودی کافی نیست. مبلغ قابل برداشت (شامل کارمزد ' . number_format($withdrawFee + $taxAmount) . ' تومان): ' . number_format($totalDeduct) . ' تومان');
        }

        $wallet->decrement('balance', $totalDeduct);
        $feeNote = ($withdrawFee + $taxAmount) > 0 ? ' | کارمزد: ' . number_format($withdrawFee + $taxAmount) . ' ت' : '';
        $wallet->transactions()->create([
            'type'          => 'withdrawal',
            'amount'        => $validated['amount'],
            'balance_after' => $wallet->fresh()->balance,
            'description'   => 'برداشت از کیف پول به کارت ' . substr($validated['card_number'], -4) . $feeNote,
            'status'        => 'pending',
            'card_number'   => $validated['card_number'],
            'admin_note'    => 'نام صاحب حساب: ' . $validated['card_owner'],
        ]);

        return back()->with('success', 'درخواست برداشت ثبت شد. ظرف ۲۴ ساعت کاری واریز می‌شود.');
    }
}
