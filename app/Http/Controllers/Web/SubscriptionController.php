<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Subscription;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function plans(): View
    {
        $plans = Plan::active()->orderBy('sort_order')->get();
        $user  = auth()->user();
        $hasUsedTrial      = $user ? $user->hasUsedTrial() : false;
        $activeSubscription = $user ? $user->activeSubscription()->with('plan')->first() : null;

        return view('subscription.plans', compact('plans', 'hasUsedTrial', 'activeSubscription'));
    }

    public function checkout(Plan $plan): View|RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Free trial: activate immediately
        if ($plan->trial_days > 0 && $plan->type !== 'free') {
            if ($user->hasUsedTrial()) {
                return redirect()->route('premium')
                    ->with('error', 'شما قبلاً از هدیه اشتراک آزمایشی استفاده کرده‌اید.');
            }

            $now = now();
            Subscription::create([
                'user_id'    => $user->id,
                'plan_id'    => $plan->id,
                'status'     => 'active',
                'starts_at'  => $now,
                'expires_at' => $now->copy()->addDays($plan->trial_days),
                'auto_renew' => false,
                'is_trial'   => true,
            ]);

            $user->update([
                'is_premium'          => true,
                'premium_expires_at'  => $now->copy()->addDays($plan->trial_days),
            ]);

            return redirect()->route('home')
                ->with('success', "دوره آزمایشی {$plan->trial_days} روزه {$plan->name_fa} با موفقیت فعال شد!");
        }

        return view('subscription.checkout', compact('plan'));
    }

    public function pay(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan_id'     => 'required|exists:plans,id',
            'coupon_code' => 'nullable|string',
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);
        $user = auth()->user();

        // Coupon discount
        $grossPrice = (int) $plan->price;
        $finalPrice = $grossPrice;
        $coupon     = null;

        if ($validated['coupon_code']) {
            $coupon = Coupon::where('code', $validated['coupon_code'])->first();
            if ($coupon && $coupon->isValidForUser($user, 'plans', $grossPrice)) {
                $discount   = $coupon->calculateDiscount($grossPrice);
                $finalPrice = max(0, $grossPrice - $discount);
            }
        }

        // Tax
        $taxPercent = (float) Setting::get('transaction_tax_percent', 0);
        $taxAmount  = (int) round($finalPrice * $taxPercent / 100);

        // Free (after coupon or free plan)
        if ($finalPrice <= 0) {
            $now = now();
            $sub = Subscription::create([
                'user_id'    => $user->id,
                'plan_id'    => $plan->id,
                'status'     => 'active',
                'starts_at'  => $now,
                'expires_at' => $now->copy()->addDays($plan->duration_days),
                'auto_renew' => false,
            ]);
            $user->update(['is_premium' => true, 'premium_expires_at' => $sub->expires_at]);

            if ($coupon) {
                $coupon->increment('used_count');
                $coupon->users()->attach($user->id, ['used_at' => now()]);
            }

            \App\Services\NotificationDispatcher::dispatch('subscription_purchased', [
                'user_name' => $user->name,
                'plan_name' => $plan->name_fa,
                'amount'    => '۰ (کد تخفیف)',
            ]);

            return redirect()->route('home')->with('success', 'اشتراک با موفقیت فعال شد.');
        }

        // Wallet payment
        if ($request->input('pay_with_wallet')) {
            $wallet = $user->getOrCreateWallet();
            $totalToPay = $finalPrice + $taxAmount;
            if ($wallet->balance < $totalToPay) {
                return back()->with('error', 'موجودی کیف پول کافی نیست. موجودی فعلی: ' . number_format($wallet->balance) . ' تومان');
            }
            $now = now();
            $sub = Subscription::create([
                'user_id'    => $user->id, 'plan_id' => $plan->id, 'status' => 'active',
                'starts_at'  => $now, 'expires_at' => $now->copy()->addDays($plan->duration_days), 'auto_renew' => false,
            ]);
            $user->update(['is_premium' => true, 'premium_expires_at' => $sub->expires_at]);
            $wallet->decrement('balance', $totalToPay);
            $wallet->transactions()->create([
                'type' => 'purchase', 'amount' => $totalToPay,
                'balance_after' => $wallet->fresh()->balance,
                'description' => "خرید اشتراک {$plan->name_fa}" . ($taxAmount > 0 ? " (مالیات: ".number_format($taxAmount)."ت)" : ""),
                'status' => 'approved',
            ]);
            if ($coupon) { $coupon->increment('used_count'); $coupon->users()->attach($user->id, ['used_at' => now()]); }
            \App\Services\NotificationDispatcher::dispatch('subscription_purchased', ['user_name' => $user->name, 'plan_name' => $plan->name_fa, 'amount' => number_format($finalPrice)]);
            return redirect()->route('home')->with('success', 'اشتراک با موفقیت فعال شد.');
        }

        // Gateway payment
        $selectedGateway = $request->input('gateway', '');
        $activeGateways  = \App\Services\PaymentService::activeGateways();
        if (empty($activeGateways)) {
            return back()->with('error', 'درگاه پرداخت فعال نیست.');
        }
        if (!$selectedGateway || !array_key_exists($selectedGateway, $activeGateways)) {
            $selectedGateway = array_key_first($activeGateways);
        }

        $now = now();
        $sub = Subscription::create([
            'user_id'    => $user->id, 'plan_id' => $plan->id, 'status' => 'pending',
            'starts_at'  => $now, 'expires_at' => $now->copy()->addDays($plan->duration_days), 'auto_renew' => false,
        ]);
        if ($coupon) { session(['pending_coupon_id_sub_' . $sub->id => $coupon->id]); }

        $service = new PaymentService($selectedGateway);
        $result  = $service->request([
            'user_id' => $user->id, 'amount' => $finalPrice, 'tax_amount' => $taxAmount, 'fee_amount' => 0,
            'description' => "خرید اشتراک {$plan->name_fa}", 'payment_type' => 'subscription',
            'payable_type' => Subscription::class, 'payable_id' => $sub->id, 'subscription_id' => $sub->id,
            'mobile' => $user->phone, 'callback_url' => route('payment.verify'),
        ]);
        if (!$result['success']) { $sub->delete(); return back()->with('error', $result['message'] ?? 'خطا در اتصال به درگاه.'); }
        return redirect($result['url']);
    }
}
