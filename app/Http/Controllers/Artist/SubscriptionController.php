<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\ArtistPlan;
use App\Models\ArtistSubscription;
use App\Models\Coupon;
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
            // Free plan - activate immediately
            ArtistSubscription::create([
                'artist_id'    => $artist->id,
                'plan_id'      => $plan->id,
                'status'       => 'active',
                'starts_at'    => now(),
                'expires_at'   => $plan->duration_days > 0 ? now()->addDays($plan->duration_days) : null,
                'tracks_used'  => 0,
                'albums_used'  => 0,
                'storage_used_mb' => 0,
            ]);

            return redirect()->route('artist.plans')
                ->with('success', "پلن {$plan->name} به صورت رایگان فعال شد!");
        }

        return view('artist.checkout', compact('plan', 'artist'));
    }

    public function pay(Request $request): RedirectResponse
    {
        $artist = auth()->user()->artist;
        abort_if(!$artist, 403, 'پروفایل هنرمند یافت نشد.');

        $validated = $request->validate([
            'plan_id' => 'required|exists:artist_plans,id',
            'email'   => 'required|email',
            'coupon_code' => 'nullable|string',
        ]);

        $plan = ArtistPlan::findOrFail($validated['plan_id']);
        $user = auth()->user();

        $grossPrice = $plan->price;
        $finalPrice = $grossPrice;
        $coupon = null;

        if ($validated['coupon_code']) {
            $coupon = Coupon::where('code', $validated['coupon_code'])->first();
            if ($coupon && $coupon->isValidForUser($user, 'artist_plans', $grossPrice)) {
                $discount = $coupon->calculateDiscount($grossPrice);
                $finalPrice = max(0, $grossPrice - $discount);
            }
        }

        // TODO: Zarinpal payment integration with $finalPrice
        // For now, create subscription as paid (demo mode)
        ArtistSubscription::create([
            'artist_id'    => $artist->id,
            'plan_id'      => $plan->id,
            'status'       => 'active',
            'starts_at'    => now(),
            'expires_at'   => $plan->duration_days > 0 ? now()->addDays($plan->duration_days) : null,
            'tracks_used'  => 0,
            'albums_used'  => 0,
            'storage_used_mb' => 0,
            'payment_ref'  => 'demo_' . uniqid() . ($coupon ? "_cp_{$coupon->code}" : ""),
        ]);

        if ($coupon) {
            $coupon->increment('used_count');
            $coupon->users()->attach($user->id, ['used_at' => now()]);
        }

        return redirect()->route('artist.plans')
            ->with('success', "پلن {$plan->name} با موفقیت خریداری و فعال شد!");
    }
}
