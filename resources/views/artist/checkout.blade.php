<x-layouts.app title="خرید اشتراک هنرمند">
@php
    $taxPercent    = (float) \App\Models\Setting::get('transaction_tax_percent', 0);
    $walletBalance = (int) auth()->user()->getOrCreateWallet()->balance;
    $activeGateways = \App\Services\PaymentService::activeGateways();
    $firstGateway  = array_key_first($activeGateways) ?? '';
@endphp
<div class="p-4 lg:p-8 max-w-xl mx-auto space-y-6" x-data="{
    originalPrice: {{ $plan->price }},
    finalPrice: {{ $plan->price }},
    taxPercent: {{ $taxPercent }},
    discount: 0,
    couponCode: '',
    loading: false,
    message: '',
    messageType: '',
    couponApplied: false,
    payMethod: '{{ $firstGateway ? 'gateway_' . $firstGateway : 'wallet' }}',

    get taxAmount() { return Math.round(this.finalPrice * this.taxPercent / 100); },
    get totalAmount() { return this.finalPrice + this.taxAmount; },

    applyCoupon() {
        if(!this.couponCode) return;
        this.loading = true;
        this.message = '';
        fetch('{{ route('coupon.validate') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code: this.couponCode, amount: this.originalPrice, category: 'artist_plans' })
        })
        .then(r => r.json())
        .then(data => {
            this.loading = false;
            if(data.error) { this.message = data.error; this.messageType = 'error'; }
            else { this.discount = data.discount; this.finalPrice = data.final_amount; this.message = data.message; this.messageType = 'success'; this.couponApplied = true; }
        })
        .catch(() => { this.loading = false; this.message = 'خطا در ارتباط'; this.messageType = 'error'; });
    }
}">

    <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center">خرید اشتراک هنرمند</h1>

    @if(session('error'))
    <div class="p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 text-red-600 text-sm">{{ session('error') }}</div>
    @endif

    <div class="glass-card rounded-2xl p-6 space-y-5">

        {{-- Plan info --}}
        <div class="text-center pb-4 border-b border-surface-200 dark:border-surface-700">
            <h2 class="text-lg font-bold text-surface-900 dark:text-white">{{ $plan->name }}</h2>
            <p class="text-sm text-surface-500 mt-1">{{ $plan->duration_days }} روز اعتبار</p>
            <div class="flex justify-center gap-4 mt-3 text-xs text-surface-500">
                <span>{{ $plan->max_tracks == 0 ? 'آهنگ نامحدود' : 'تا '.$plan->max_tracks.' آهنگ' }}</span>
                <span>|</span>
                <span>{{ $plan->max_albums == 0 ? 'آلبوم نامحدود' : 'تا '.$plan->max_albums.' آلبوم' }}</span>
                <span>|</span>
                <span>{{ $plan->max_storage_mb == 0 ? 'فضا نامحدود' : $plan->max_storage_mb.' MB' }}</span>
            </div>
        </div>

        {{-- Coupon --}}
        <div class="space-y-2">
            <label class="text-xs font-medium text-surface-500">کد تخفیف</label>
            <div class="flex gap-2">
                <input type="text" x-model="couponCode" :disabled="couponApplied" placeholder="کد تخفیف..."
                       class="flex-1 px-4 py-2.5 rounded-xl border border-surface-200 dark:border-surface-700 bg-white dark:bg-surface-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none disabled:opacity-50">
                <button @click="applyCoupon" :disabled="loading || !couponCode || couponApplied"
                        class="btn-primary !px-4 !py-2 !text-xs whitespace-nowrap disabled:opacity-40">
                    <span x-show="!loading">اعمال</span><span x-show="loading">...</span>
                </button>
            </div>
            <p x-show="message" :class="messageType === 'success' ? 'text-emerald-500' : 'text-red-500'" class="text-xs" x-text="message"></p>
        </div>

        {{-- Invoice --}}
        <div class="rounded-xl bg-surface-50 dark:bg-surface-800 p-4 space-y-2 text-sm">
            <div class="flex justify-between text-surface-600 dark:text-surface-400">
                <span>قیمت پلن</span>
                <span :class="couponApplied ? 'line-through opacity-50' : ''">{{ number_format($plan->price) }} تومان</span>
            </div>
            <div x-show="couponApplied" class="flex justify-between text-emerald-600 dark:text-emerald-400">
                <span>تخفیف</span>
                <span x-text="'- ' + Number(discount).toLocaleString() + ' تومان'"></span>
            </div>
            @if($taxPercent > 0)
            <div class="flex justify-between text-surface-500">
                <span>مالیات ({{ $taxPercent }}٪)</span>
                <span x-text="Number(taxAmount).toLocaleString() + ' تومان'"></span>
            </div>
            @endif
            <div class="flex justify-between font-bold text-surface-900 dark:text-white border-t border-surface-200 dark:border-surface-700 pt-2">
                <span>مبلغ قابل پرداخت</span>
                <span class="text-primary-500 text-lg" x-text="Number(totalAmount).toLocaleString() + ' تومان'"></span>
            </div>
        </div>

        {{-- Payment Method --}}
        <div class="space-y-3">
            <p class="text-sm font-medium text-surface-700 dark:text-surface-300">روش پرداخت</p>
            <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition"
                   :class="payMethod === 'wallet' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-surface-200 dark:border-surface-700'">
                <input type="radio" x-model="payMethod" value="wallet" class="text-primary-500">
                <div class="flex-1">
                    <p class="text-sm font-medium text-surface-900 dark:text-white">کیف پول</p>
                    <p class="text-xs text-surface-500">موجودی: {{ number_format($walletBalance) }} تومان</p>
                </div>
                <span class="text-xs px-2 py-1 rounded-full"
                      :class="{{ $walletBalance }} >= totalAmount ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'">
                    <span x-text="{{ $walletBalance }} >= totalAmount ? 'کافی' : 'ناکافی'"></span>
                </span>
            </label>
            {{-- Each gateway as separate radio --}}
            @foreach($activeGateways as $gkey => $glabel)
            <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition"
                   :class="payMethod === 'gateway_{{ $gkey }}' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-surface-200 dark:border-surface-700'">
                <input type="radio" x-model="payMethod" value="gateway_{{ $gkey }}" class="text-primary-500">
                <span class="text-sm font-medium text-surface-900 dark:text-white">{{ $glabel }}</span>
            </label>
            @endforeach
        </div>

        {{-- Wallet form --}}
        <form x-show="payMethod === 'wallet'" action="{{ route('artist.subscription.pay') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <input type="hidden" name="coupon_code" :value="couponCode">
            <input type="hidden" name="pay_with_wallet" value="1">
            <button type="submit" :disabled="{{ $walletBalance }} < totalAmount"
                    class="w-full py-3.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white font-semibold text-sm transition disabled:opacity-40 disabled:cursor-not-allowed">
                پرداخت از کیف پول
            </button>
            <p x-show="{{ $walletBalance }} < totalAmount" class="text-xs text-red-500 text-center mt-2">
                موجودی کافی نیست — <a href="{{ route('wallet') }}" class="underline">شارژ کیف پول</a>
            </p>
        </form>

        {{-- One form per gateway --}}
        @foreach($activeGateways as $gkey => $glabel)
        <form x-show="payMethod === 'gateway_{{ $gkey }}'" action="{{ route('artist.subscription.pay') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <input type="hidden" name="coupon_code" :value="couponCode">
            <input type="hidden" name="gateway" value="{{ $gkey }}">
            <button type="submit" class="w-full py-3.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white font-semibold text-sm transition">
                پرداخت با {{ $glabel }}
            </button>
        </form>
        @endforeach

        @if(empty($activeGateways))
        <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 text-xs text-center">
            درگاه پرداخت آنلاین فعال نیست.
        </div>
        @endif
    </div>

    <a href="{{ route('artist.plans') }}" class="text-sm text-surface-500 hover:text-primary-500 text-center block">← بازگشت</a>
</div>
</x-layouts.app>
