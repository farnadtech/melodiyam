<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\ArtistPlan;
use App\Models\ArtistSubscription;
use App\Models\Coupon;
use App\Models\Setting;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $artist = auth()->user()->artist;
        abort_if(!$artist, 403, 'پروفایل هنرمند یافت نشد.');

        $plans = ArtistPlan::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('price')
            ->get();

        $activeSub = $artist->load('activeSubscription')->activeSubscription;

        return view('artist.plans', compact('plans', 'activeSub', 'artist'));
    }

    public function checkout(ArtistPlan $plan): View|RedirectResponse
    {
        $artist = auth()->user()->artist;
        abort_if(!$artist, 403, 'پروفایل هنرمند یافت نشد.');

        if ($plan->price == 0) {
            // Cancel current active sub if upgrading/changing
            ArtistSubscription::where('artist_id', $artist->id)
                ->where('status', 'active')
                ->update(['status' => 'cancelled']);

            ArtistSubscription::create([
                'artist_id'       => $artist->id,
                'plan_id'         => $plan->id,
                'status'          => 'active',
                'starts_at'       => now(),
                'expires_at'      => $plan->duration_days > 0 ? now()->addDays($plan->duration_days) : null,
                'tracks_used'     => 0,
                'albums_used'     => 0,
                'storage_used_mb' => 0,
            ]);

            return redirect()->route('artist.plans')
                ->with('success', "پلن {$plan->name} به صورت رایگان فعال شد!");
        }

        // Pass current sub for upgrade info in view
        $currentSub = $artist->activeSubscription;
        $isUpgrade  = $currentSub && $plan->price > $currentSub->plan->price;

        return view('artist.checkout', compact('plan', 'artist', 'currentSub', 'isUpgrade'));
    }

    public function pay(Request $request): RedirectResponse
    {
        $artist = auth()->user()->artist;
        abort_if(!$artist, 403, 'پروفایل هنرمند یافت نشد.');

        $validated = $request->validate([
            'plan_id'     => 'required|exists:artist_plans,id',
            'coupon_code' => 'nullable|string',
        ]);

        $plan = ArtistPlan::findOrFail($validated['plan_id']);
        $user = auth()->user();

        $grossPrice = (int) $plan->price;
        $finalPrice = $grossPrice;
        $coupon     = null;

        if ($validated['coupon_code']) {
            $coupon = Coupon::where('code', $validated['coupon_code'])->first();
            if ($coupon && $coupon->isValidForUser($user, 'artist_plans', $grossPrice)) {
                $discount   = $coupon->calculateDiscount($grossPrice);
                $finalPrice = max(0, $grossPrice - $discount);
            }
        }

        // Tax
        $taxPercent = (float) Setting::get('transaction_tax_percent', 0);
        $taxAmount  = (int) round($finalPrice * $taxPercent / 100);

        // Free after coupon
        if ($finalPrice <= 0) {
            $sub = ArtistSubscription::create([
                'artist_id'       => $artist->id,
                'plan_id'         => $plan->id,
                'status'          => 'active',
                'starts_at'       => now(),
                'expires_at'      => $plan->duration_days > 0 ? now()->addDays($plan->duration_days) : null,
                'tracks_used'     => 0,
                'albums_used'     => 0,
                'storage_used_mb' => 0,
            ]);

            if ($coupon) {
                $coupon->increment('used_count');
                $coupon->users()->attach($user->id, ['used_at' => now()]);
            }

            return redirect()->route('artist.plans')
                ->with('success', "پلن {$plan->name} با موفقیت فعال شد!");
        }

        // Wallet payment
        if ($request->input('pay_with_wallet')) {
            $wallet = $user->getOrCreateWallet();
            $totalToPay = $finalPrice + $taxAmount;
            if ($wallet->balance < $totalToPay) {
                return back()->with('error', 'موجودی کیف پول کافی نیست. موجودی فعلی: ' . number_format($wallet->balance) . ' تومان');
            }
            // Cancel existing active subscription
            ArtistSubscription::where('artist_id', $artist->id)
                ->where('status', 'active')
                ->update(['status' => 'cancelled']);

            $sub = ArtistSubscription::create([
                'artist_id' => $artist->id, 'plan_id' => $plan->id, 'status' => 'active',
                'starts_at' => now(), 'expires_at' => $plan->duration_days > 0 ? now()->addDays($plan->duration_days) : null,
                'tracks_used' => 0, 'albums_used' => 0, 'storage_used_mb' => 0,
            ]);
            $wallet->decrement('balance', $totalToPay);
            $wallet->transactions()->create([
                'type' => 'purchase', 'amount' => $totalToPay, 'balance_after' => $wallet->fresh()->balance,
                'description' => "خرید پلن هنرمند: {$plan->name}" . ($taxAmount > 0 ? " (مالیات: ".number_format($taxAmount)."ت)" : ""),
                'status' => 'approved',
            ]);
            if ($coupon) { $coupon->increment('used_count'); $coupon->users()->attach($user->id, ['used_at' => now()]); }
            return redirect()->route('artist.plans')->with('success', "پلن {$plan->name} با موفقیت فعال شد!");
        }

        // Gateway payment
        $selectedGateway = $request->input('gateway', '');
        $activeGateways  = \App\Services\PaymentService::activeGateways();
        if (empty($activeGateways)) { return back()->with('error', 'درگاه پرداخت فعال نیست.'); }
        if (!$selectedGateway || !array_key_exists($selectedGateway, $activeGateways)) { $selectedGateway = array_key_first($activeGateways); }

        // Create pending subscription
        $sub = ArtistSubscription::create([
            'artist_id'       => $artist->id,
            'plan_id'         => $plan->id,
            'status'          => 'pending',
            'starts_at'       => now(),
            'expires_at'      => $plan->duration_days > 0 ? now()->addDays($plan->duration_days) : null,
            'tracks_used'     => 0,
            'albums_used'     => 0,
            'storage_used_mb' => 0,
        ]);

        if ($coupon) { session(['pending_coupon_id_artistsub_' . $sub->id => $coupon->id]); }

        $service = new PaymentService($selectedGateway);
        $result  = $service->request([
            'user_id'      => $user->id,
            'amount'       => $finalPrice,
            'tax_amount'   => $taxAmount,
            'fee_amount'   => 0,
            'description'  => "خرید پلن هنرمند: {$plan->name}",
            'payment_type' => 'artist_subscription',
            'payable_type' => ArtistSubscription::class,
            'payable_id'   => $sub->id,
            'mobile'       => $user->phone,
            'callback_url' => route('payment.verify'),
        ]);

        if (!$result['success']) {
            $sub->delete();
            return back()->with('error', $result['message'] ?? 'خطا در اتصال به درگاه پرداخت.');
        }

        return redirect($result['url']);
    }
}
