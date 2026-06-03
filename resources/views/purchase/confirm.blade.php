<x-layouts.app :title="'خرید: ' . $item->title">
@php
    $taxPercent    = (float) \App\Models\Setting::get('transaction_tax_percent', 0);
    $taxAmount     = (int) round($finalPrice * $taxPercent / 100);
    $totalAmount   = $finalPrice + $taxAmount;
    $walletBalance = (int) $wallet->balance;
    $activeGateways = \App\Services\PaymentService::activeGateways();
@endphp
<div class="min-h-[70vh] flex items-center justify-center p-4">
    <div class="w-full max-w-md" x-data="{
        originalPrice: {{ $finalPrice }},
        finalPrice: {{ $finalPrice }},
        taxPercent: {{ $taxPercent }},
        discount: 0,
        couponCode: '',
        loading: false,
        message: '',
        messageType: '',
        couponApplied: false,
        payMethod: 'wallet',
        selectedGateway: '{{ array_key_first($activeGateways) ?? '' }}',

        get taxAmount() { return Math.round(this.finalPrice * this.taxPercent / 100); },
        get totalAmount() { return this.finalPrice + this.taxAmount; },

        applyCoupon() {
            if(!this.couponCode) return;
            this.loading = true;
            this.message = '';
            fetch('{{ route('coupon.validate') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ code: this.couponCode, amount: this.originalPrice, category: '{{ $type }}s' })
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

        @if(session('error'))
        <div class="mb-4 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">{{ session('error') }}</div>
        @endif
        @if(session('info'))
        <div class="mb-4 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 text-sm">{{ session('info') }}</div>
        @endif

        <div class="card p-6 space-y-5">

            {{-- Header --}}
            <div class="text-center">
                <div class="w-14 h-14 rounded-full bg-primary-500/10 border border-primary-500/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-surface-900 dark:text-white">تأیید خرید</h1>
            </div>

            {{-- Item --}}
            <div class="flex items-center gap-4 p-4 rounded-xl bg-surface-100 dark:bg-surface-800">
                <img src="{{ $item->getCoverUrl() }}" alt="{{ $item->title }}" class="w-14 h-14 rounded-xl object-cover flex-shrink-0">
                <div class="min-w-0">
                    <p class="text-xs text-surface-400">{{ $type === 'track' ? 'آهنگ' : 'آلبوم' }}</p>
                    <p class="font-semibold text-surface-900 dark:text-white truncate">{{ $item->title }}</p>
                    <p class="text-sm text-surface-500">{{ $item->artist?->display_name }}</p>
                </div>
            </div>

            {{-- Coupon --}}
            <div class="space-y-2">
                <label class="text-xs font-medium text-surface-500">کد تخفیف</label>
                <div class="flex gap-2">
                    <input type="text" x-model="couponCode" :disabled="couponApplied" placeholder="وارد کنید..."
                           class="flex-1 bg-surface-100 dark:bg-surface-800 border-none rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary-500 disabled:opacity-50">
                    <button @click="applyCoupon" :disabled="loading || !couponCode || couponApplied"
                            class="btn-primary !px-4 !py-2 !text-xs whitespace-nowrap disabled:opacity-50">
                        <span x-show="!loading">اعمال</span><span x-show="loading">...</span>
                    </button>
                </div>
                <p x-show="message" :class="messageType === 'success' ? 'text-emerald-500' : 'text-red-500'" class="text-xs" x-text="message"></p>
            </div>

            {{-- Invoice --}}
            <div class="space-y-2 p-4 rounded-xl bg-surface-100 dark:bg-surface-800 text-sm">
                <div class="flex justify-between text-surface-600 dark:text-surface-400">
                    <span>قیمت</span>
                    <span :class="couponApplied ? 'line-through opacity-50' : ''">{{ number_format($finalPrice) }} ت</span>
                </div>
                <div x-show="couponApplied" class="flex justify-between text-emerald-500">
                    <span>تخفیف</span>
                    <span x-text="'- ' + Number(discount).toLocaleString() + ' ت'"></span>
                </div>
                @if($taxPercent > 0)
                <div class="flex justify-between text-surface-500">
                    <span>مالیات ({{ $taxPercent }}٪)</span>
                    <span x-text="Number(taxAmount).toLocaleString() + ' ت'"></span>
                </div>
                @endif
                <div class="flex justify-between font-bold text-surface-900 dark:text-white border-t border-surface-200 dark:border-surface-700 pt-2">
                    <span>مبلغ نهایی</span>
                    <span class="text-xl text-primary-500" x-text="Number(totalAmount).toLocaleString() + ' ت'"></span>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="space-y-2">
                <p class="text-xs font-medium text-surface-500">روش پرداخت</p>

                {{-- Wallet --}}
                <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition"
                       :class="payMethod === 'wallet' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-surface-200 dark:border-surface-700'">
                    <input type="radio" x-model="payMethod" value="wallet" class="text-primary-500">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-surface-900 dark:text-white">کیف پول</p>
                        <p class="text-xs text-surface-500">موجودی: {{ number_format($walletBalance) }} ت</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full"
                          :class="{{ $walletBalance }} >= totalAmount ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'">
                        <span x-text="{{ $walletBalance }} >= totalAmount ? 'کافی' : 'ناکافی'"></span>
                    </span>
                </label>

                {{-- Gateways --}}
                @foreach($activeGateways as $gkey => $glabel)
                <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition"
                       :class="payMethod === 'gateway' && selectedGateway === '{{ $gkey }}' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-surface-200 dark:border-surface-700'">
                    <input type="radio" x-model="payMethod" value="gateway" @click="selectedGateway = '{{ $gkey }}'" class="text-primary-500">
                    <span class="text-sm font-medium text-surface-900 dark:text-white">{{ $glabel }}</span>
                </label>
                @endforeach
            </div>

            {{-- Wallet form --}}
            <form x-show="payMethod === 'wallet'" action="{{ route('purchase.submit') }}" method="POST" x-cloak>
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="id" value="{{ $item->id }}">
                <input type="hidden" name="coupon_code" :value="couponCode">
                <div class="flex gap-3 mt-2">
                    <a href="{{ url()->previous() }}" class="btn-secondary flex-1 justify-center text-sm">انصراف</a>
                    <button type="submit" :disabled="{{ $walletBalance }} < totalAmount"
                            class="btn-primary flex-1 justify-center text-sm disabled:opacity-40 disabled:cursor-not-allowed">
                        خرید از کیف پول
                    </button>
                </div>
                <p x-show="{{ $walletBalance }} < totalAmount" class="text-xs text-red-500 text-center mt-2">
                    موجودی کافی نیست — <a href="{{ route('wallet') }}" class="underline">شارژ کیف پول</a>
                </p>
            </form>

            {{-- Gateway form --}}
            <form x-show="payMethod === 'gateway'" action="{{ route('purchase.submit') }}" method="POST" x-cloak>
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="id" value="{{ $item->id }}">
                <input type="hidden" name="coupon_code" :value="couponCode">
                <input type="hidden" name="gateway" :value="selectedGateway">
                <div class="flex gap-3 mt-2">
                    <a href="{{ url()->previous() }}" class="btn-secondary flex-1 justify-center text-sm">انصراف</a>
                    <button type="submit" class="btn-primary flex-1 justify-center text-sm">
                        پرداخت آنلاین
                    </button>
                </div>
            </form>

            @if(empty($activeGateways))
            <p x-show="{{ $walletBalance }} < totalAmount" class="text-xs text-surface-500 text-center">
                موجودی کافی ندارید. <a href="{{ route('wallet') }}" class="text-primary-500 hover:underline">شارژ کیف پول</a>
            </p>
            @endif

        </div>
    </div>
</div>
</x-layouts.app>
