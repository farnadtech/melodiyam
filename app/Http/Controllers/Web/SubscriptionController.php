<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function plans(): View
    {
        $plans = Plan::active()->orderBy('sort_order')->get();
        return view('subscription.plans', compact('plans'));
    }

    public function checkout(Plan $plan): View|RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // If plan has trial days → activate for free immediately
        if ($plan->trial_days > 0 && $plan->type !== 'free') {
            $user = auth()->user();

            // check user hasn't already used a trial
            $alreadyUsed = Subscription::where('user_id', $user->id)
                ->where('plan_id', $plan->id)
                ->exists();

            if (!$alreadyUsed) {
                $now = now();
                Subscription::create([
                    'user_id'    => $user->id,
                    'plan_id'    => $plan->id,
                    'status'     => 'active',
                    'starts_at'  => $now,
                    'expires_at' => $now->copy()->addDays($plan->trial_days),
                    'auto_renew' => false,
                ]);

                $user->update([
                    'is_premium'          => true,
                    'premium_expires_at'  => $now->copy()->addDays($plan->trial_days),
                ]);

                return redirect()->route('home')
                    ->with('success', "دوره آزمایشی {$plan->trial_days} روزه {$plan->name_fa} فعال شد!");
            }

            return redirect()->route('premium')
                ->with('error', 'قبلاً از دوره آزمایشی این پلن استفاده کرده‌اید.');
        }

        return view('subscription.checkout', compact('plan'));
    }

    public function pay()
    {
        // Zarinpal integration placeholder
        return redirect()->route('home');
    }

    public function verify()
    {
        // Zarinpal verify placeholder
        return redirect()->route('home');
    }
}
