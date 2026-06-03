<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\CommissionRule;
use App\Models\Coupon;
use App\Models\Sale;
use App\Models\Track;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function confirm(Request $request)
    {
        $type = $request->query('type');
        $id   = $request->query('id');

        if (!in_array($type, ['track', 'album']) || !$id) {
            abort(404);
        }

        $user = auth()->user();

        $item = $type === 'track'
            ? Track::with('artist')->findOrFail($id)
            : Album::with('artist')->findOrFail($id);

        if (!$item->is_for_sale) {
            return redirect()->back()->with('error', 'این محتوا قابل خرید نیست.');
        }

        if ($this->userHasPlanAccess($user)) {
            return redirect()->back()->with('info', 'شما با پلن فعالتان دسترسی رایگان به این محتوا دارید.');
        }

        $alreadyBought = Sale::where('buyer_id', $user->id)
            ->where('saleable_type', get_class($item))
            ->where('saleable_id', $item->id)
            ->where('status', 'completed')
            ->exists();

        if ($alreadyBought) {
            return redirect()->back()->with('info', 'این محتوا را قبلاً خریده‌اید.');
        }

        $wallet     = $user->getOrCreateWallet();
        $finalPrice = (int) ($item->discount_price ?: $item->price);

        return view('purchase.confirm', compact('item', 'type', 'wallet', 'finalPrice'));
    }

    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:track,album',
            'id'   => 'required|integer',
            'coupon_code' => 'nullable|string',
        ]);

        $user = auth()->user();

        // چک کاربر دسترسی به محتوای پولی از طریق پلن داره؟
        if ($this->userHasPlanAccess($user)) {
            return back()->with('info', 'شما با پلن فعالتان دسترسی رایگان به این محتوا دارید.');
        }

        /** @var Track|Album $item */
        $item = $validated['type'] === 'track'
            ? Track::findOrFail($validated['id'])
            : Album::findOrFail($validated['id']);

        if (!$item->is_for_sale) {
            return back()->with('error', 'این محتوا قابل خرید نیست.');
        }

        // چک کاربر قبلاً خریده؟
        $alreadyBought = Sale::where('buyer_id', $user->id)
            ->where('saleable_type', get_class($item))
            ->where('saleable_id', $item->id)
            ->where('status', 'completed')
            ->exists();

        if ($alreadyBought) {
            return back()->with('info', 'این محتوا را قبلاً خریده‌اید.');
        }

        $grossPrice = (int) ($item->discount_price ?: $item->price);
        $finalPrice = $grossPrice;
        $coupon = null;

        if ($validated['coupon_code']) {
            $coupon = Coupon::where('code', $validated['coupon_code'])->first();
            if ($coupon && $coupon->isValidForUser($user, $validated['type'] . 's', $grossPrice)) {
                $discount = $coupon->calculateDiscount($grossPrice);
                $finalPrice = max(0, $grossPrice - $discount);
            } else {
                return back()->with('error', 'کد تخفیف معتبر نیست یا منقضی شده است.');
            }
        }

        if ($finalPrice < 0) {
            return back()->with('error', 'قیمت معتبر نیست.');
        }

        $wallet = $user->getOrCreateWallet();

        // Gateway payment option
        if ($request->input('gateway') && !$request->input('pay_with_wallet', false)) {
            $selectedGateway = $request->input('gateway');
            $activeGateways  = \App\Services\PaymentService::activeGateways();
            if (!array_key_exists($selectedGateway, $activeGateways)) {
                $selectedGateway = array_key_first($activeGateways);
            }
            if ($selectedGateway) {
                // Tax
                $taxPercent = (float) \App\Models\Setting::get('transaction_tax_percent', 0);
                $taxAmount  = (int) round($finalPrice * $taxPercent / 100);

                $service = new \App\Services\PaymentService($selectedGateway);
                $result  = $service->request([
                    'user_id'      => $user->id,
                    'amount'       => $finalPrice,
                    'tax_amount'   => $taxAmount,
                    'fee_amount'   => 0,
                    'description'  => 'خرید: ' . $item->title,
                    'payment_type' => 'track_purchase',
                    'payable_type' => get_class($item),
                    'payable_id'   => $item->id,
                    'mobile'       => $user->phone,
                    'callback_url' => route('payment.verify'),
                ]);
                if (!$result['success']) {
                    return back()->with('error', $result['message'] ?? 'خطا در اتصال به درگاه.');
                }
                // Store pending purchase data in session for verify callback
                session([
                    'pending_purchase_' . $result['payment']->id => [
                        'type'       => $validated['type'],
                        'item_id'    => $item->id,
                        'coupon_id'  => $coupon?->id,
                    ]
                ]);
                return redirect($result['url']);
            }
        }

        if ($wallet->balance < $finalPrice) {
            return back()->with('error', 'موجودی کیف پول کافی نیست. موجودی فعلی: ' . number_format($wallet->balance) . ' تومان');
        }
        // پیدا کردن قانون کمیسیون
        $artistId = $item instanceof Track ? $item->artist_id : $item->artist_id;
        $genreId  = $item instanceof Track ? $item->genre_id  : $item->genre_id;
        $rule = CommissionRule::getApplicableRule($genreId, $artistId);

        $commissionAmount = 0;
        $netAmount        = $finalPrice;

        if ($rule) {
            $calc = $rule->calculateCommission($finalPrice);
            $commissionAmount = $calc['commission'];
            $netAmount        = $calc['net'];
        }

        // پیدا کردن seller (user_id هنرمند)
        $artist = $item instanceof Track ? $item->artist : $item->artist;
        $sellerId = $artist?->user_id ?? 1; // fallback به ادمین

        // کسر از کیف پول خریدار
        if ($finalPrice > 0) {
            $wallet->decrement('balance', $finalPrice);
            $wallet->transactions()->create([
                'type'          => 'purchase',
                'amount'        => $finalPrice,
                'balance_after' => $wallet->fresh()->balance,
                'description'   => 'خرید: ' . $item->title . ($coupon ? " (با کد تخفیف: {$coupon->code})" : ""),
                'status'        => 'approved',
            ]);
        }

        // واریز به کیف پول هنرمند (اگر user_id داره)
        if ($sellerId && $sellerId !== $user->id && $netAmount > 0) {
            $sellerUser = \App\Models\User::find($sellerId);
            if ($sellerUser) {
                $sellerWallet = $sellerUser->getOrCreateWallet();
                $sellerWallet->increment('balance', $netAmount);
                $sellerWallet->transactions()->create([
                    'type'          => 'sale_income',
                    'amount'        => $netAmount,
                    'balance_after' => $sellerWallet->fresh()->balance,
                    'description'   => 'درآمد فروش: ' . $item->title,
                    'status'        => 'approved',
                ]);
            }
        }

        // ثبت فروش
        $sale = Sale::create([
            'buyer_id'          => $user->id,
            'seller_id'         => $sellerId,
            'saleable_type'     => get_class($item),
            'saleable_id'       => $item->id,
            'gross_amount'      => $grossPrice,
            'commission_amount' => $commissionAmount,
            'net_amount'        => $netAmount,
            'commission_rule_id' => $rule?->id,
            'status'            => 'completed',
            'payment_method'    => 'wallet',
        ]);

        // ارسال اعلان به هنرمند
        if ($sellerId && $sellerId !== $user->id) {
            $sellerUser = \App\Models\User::find($sellerId);
            if ($sellerUser) {
                \App\Services\NotificationDispatcher::dispatch('track_purchased_artist', [
                    'track_title' => $item->title,
                    'amount' => number_format($finalPrice),
                ], $sellerUser);
            }
        }

        // ثبت استفاده از کوپن
        if ($coupon) {
            $coupon->increment('used_count');
            $coupon->users()->attach($user->id, ['used_at' => now()]);
        }

        return redirect()->route('library.purchases')->with('success', 'خرید با موفقیت انجام شد.');
    }

    public function userPurchases()
    {
        $user = auth()->user();

        $purchases = Sale::where('buyer_id', $user->id)
            ->where('status', 'completed')
            ->with(['saleable'])
            ->latest()
            ->paginate(20);

        return view('library.purchases', compact('purchases'));
    }

    protected function userHasPlanAccess($user): bool
    {
        if (!$user) return false;
        $subscription = $user->activeSubscription;
        if (!$subscription) return false;
        return (bool) ($subscription->plan?->includes_paid_content ?? false);
    }
}
