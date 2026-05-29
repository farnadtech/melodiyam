<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function plans(): View
    {
        $plans = Plan::active()->orderBy('sort_order')->get();
        $user = auth()->user();
        $hasUsedTrial = $user ? $user->hasUsedTrial() : false;
        $activeSubscription = $user ? $user->activeSubscription()->with('plan')->first() : null;

        return view('subscription.plans', compact('plans', 'hasUsedTrial', 'activeSubscription'));
    }

    public function checkout(Plan $plan): View|RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // If plan has trial days → activate for free immediately
        if ($plan->trial_days > 0 && $plan->type !== 'free') {
            // check user hasn't already used ANY trial
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

    public function pay(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'coupon_code' => 'nullable|string',
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);
        $user = auth()->user();

        $grossPrice = $plan->price;
        $finalPrice = $grossPrice;
        $coupon = null;

        if ($validated['coupon_code']) {
            $coupon = Coupon::where('code', $validated['coupon_code'])->first();
            if ($coupon && $coupon->isValidForUser($user, 'plans', $grossPrice)) {
                $discount = $coupon->calculateDiscount($grossPrice);
                $finalPrice = max(0, $grossPrice - $discount);
            }
        }

        // TODO: Zarinpal integration with $finalPrice
        // For demo, if price is 0 (fully discounted), activate immediately
        if ($finalPrice <= 0) {
            $now = now();
            Subscription::create([
                'user_id'    => $user->id,
                'plan_id'    => $plan->id,
                'status'     => 'active',
                'starts_at'  => $now,
                'expires_at' => $now->copy()->addDays($plan->duration_days),
                'auto_renew' => false,
            ]);

            $user->update([
                'is_premium'          => true,
                'premium_expires_at'  => $now->copy()->addDays($plan->duration_days),
            ]);

            if ($coupon) {
                $coupon->increment('used_count');
                $coupon->users()->attach($user->id, ['used_at' => now()]);
            }

            return redirect()->route('home')->with('success', 'اشتراک با موفقیت فعال شد.');
        }

        return redirect()->route('home');
    }

    public function verify()
    {
        // Zarinpal verify placeholder
        return redirect()->route('home');
    }
}
