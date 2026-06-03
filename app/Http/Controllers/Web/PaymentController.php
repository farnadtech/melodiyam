<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ArtistSubscription;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Wallet;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Unified verify callback — called by all gateways after payment.
     */
    public function verify(Request $request)
    {
        try {
            $service = new PaymentService();
            $result  = $service->verify($request);

            if (!$result['success']) {
                /** @var Payment|null $payment */
                $payment = $result['payment'] ?? null;
                $errorMsg = $result['message'] ?? 'پرداخت ناموفق بود.';

                // Redirect back to the relevant page with error
                if ($payment) {
                    return match ($payment->payment_type) {
                        'subscription'        => redirect()->route('premium')->with('error', $errorMsg),
                        'artist_subscription' => redirect()->route('artist.plans')->with('error', $errorMsg),
                        'wallet_deposit'      => redirect()->route('wallet')->with('error', $errorMsg),
                        default               => redirect()->route('home')->with('error', $errorMsg),
                    };
                }
                return redirect()->route('home')->with('error', $errorMsg);
            }

            /** @var Payment $payment */
            $payment = $result['payment'];

            DB::transaction(function () use ($payment) {
                match ($payment->payment_type) {
                    'subscription'        => $this->activateSubscription($payment),
                    'artist_subscription' => $this->activateArtistSubscription($payment),
                    'wallet_deposit'      => $this->creditWallet($payment),
                    default               => null,
                };
            });

            $message = 'پرداخت با موفقیت انجام شد. کد پیگیری: ' . $result['ref_id'];

            return match ($payment->payment_type) {
                'subscription'        => redirect()->route('premium')->with('success', $message),
                'artist_subscription' => redirect()->route('artist.plans')->with('success', $message),
                'wallet_deposit'      => redirect()->route('wallet')->with('success', $message),
                default               => redirect()->route('home')->with('success', $message),
            };
        } catch (\Exception $e) {
            Log::error('Payment verify exception: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'خطایی در تأیید پرداخت رخ داد.');
        }
    }

    // ── Activate user subscription after successful payment ──

    protected function activateSubscription(Payment $payment): void
    {
        // payable = Subscription (pre-created as pending)
        $sub = $payment->payable;
        if ($sub instanceof Subscription) {
            $sub->update(['status' => 'active']);
            $user = $payment->user;
            $user->update([
                'is_premium'         => true,
                'premium_expires_at' => $sub->expires_at,
            ]);
        }

        // Use coupon if stored in payment description
        // Notify admin
        \App\Services\NotificationDispatcher::dispatch('subscription_purchased', [
            'user_name' => $payment->user->name,
            'plan_name' => $sub?->plan?->name_fa ?? '—',
            'amount'    => number_format($payment->amount),
        ]);
    }

    // ── Activate artist subscription after successful payment ──

    protected function activateArtistSubscription(Payment $payment): void
    {
        $sub = $payment->payable;
        if ($sub instanceof ArtistSubscription) {
            // Cancel any other active subscription for this artist
            ArtistSubscription::where('artist_id', $sub->artist_id)
                ->where('status', 'active')
                ->where('id', '!=', $sub->id)
                ->update(['status' => 'cancelled']);

            $sub->update(['status' => 'active']);
        }
    }

    // ── Credit wallet after successful gateway deposit ──

    protected function creditWallet(Payment $payment): void
    {
        $wallet = $payment->user->getOrCreateWallet();
        $wallet->increment('balance', $payment->amount);

        $wallet->transactions()->create([
            'type'          => 'deposit',
            'amount'        => $payment->amount,
            'balance_after' => $wallet->fresh()->balance,
            'description'   => 'شارژ آنلاین کیف پول — درگاه: ' . $payment->gatewayLabel() . ' — کد پیگیری: ' . $payment->ref_id,
            'status'        => 'approved',
            'reference_number' => $payment->ref_id,
        ]);
    }
}
