<x-layouts.app :title="'خرید: ' . $item->title">
    <div class="min-h-[70vh] flex items-center justify-center p-4">
        <div class="w-full max-w-md" x-data="{ 
            originalPrice: {{ $finalPrice }},
            finalPrice: {{ $finalPrice }},
            discount: 0,
            couponCode: '',
            loading: false,
            message: '',
            messageType: '',
            couponApplied: false,
            
            applyCoupon() {
                if(!this.couponCode) return;
                this.loading = true;
                this.message = '';
                
                fetch('{{ route('coupon.validate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        code: this.couponCode,
                        amount: this.originalPrice,
                        category: '{{ $type }}s'
                    })
                })
                .then(r => r.json())
                .then(data => {
                    this.loading = false;
                    if(data.error) {
                        this.message = data.error;
                        this.messageType = 'error';
                    } else {
                        this.discount = data.discount;
                        this.finalPrice = data.final_amount;
                        this.message = data.message;
                        this.messageType = 'success';
                        this.couponApplied = true;
                    }
                })
                .catch(e => {
                    this.loading = false;
                    this.message = 'خطایی در برقراری ارتباط رخ داد.';
                    this.messageType = 'error';
                });
            }
        }">

            @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                {{ session('error') }}
            </div>
            @endif
            @if(session('info'))
            <div class="mb-4 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 text-sm">
                {{ session('info') }}
            </div>
            @endif

            <div class="card p-6 space-y-6">

                {{-- Header --}}
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-primary-500/10 border border-primary-500/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-surface-900 dark:text-white">تأیید خرید</h1>
                    <p class="text-sm text-surface-500 mt-1">جزئیات خرید را بررسی کنید</p>
                </div>

                {{-- Item Info --}}
                <div class="flex items-center gap-4 p-4 rounded-xl bg-surface-100 dark:bg-surface-800">
                    <img src="{{ $item->getCoverUrl() }}" alt="{{ $item->title }}"
                         class="w-16 h-16 rounded-xl object-cover flex-shrink-0 shadow-md">
                    <div class="min-w-0">
                        <p class="text-xs text-surface-400 mb-0.5">{{ $type === 'track' ? 'آهنگ' : 'آلبوم' }}</p>
                        <p class="font-semibold text-surface-900 dark:text-white truncate">{{ $item->title }}</p>
                        <p class="text-sm text-surface-500 truncate">{{ $item->artist?->display_name }}</p>
                    </div>
                </div>

                {{-- Coupon Input --}}
                <div class="space-y-2">
                    <label class="text-xs font-medium text-surface-500">کد تخفیف</label>
                    <div class="flex gap-2">
                        <input type="text" x-model="couponCode" :disabled="couponApplied" placeholder="وارد کنید..." class="flex-1 bg-surface-100 dark:bg-surface-800 border-none rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary-500 disabled:opacity-50">
                        <button @click="applyCoupon" :disabled="loading || !couponCode || couponApplied" class="btn-primary !px-4 !py-2 !text-xs whitespace-nowrap disabled:opacity-50">
                            <span x-show="!loading">اعمال</span>
                            <span x-show="loading">...</span>
                        </button>
                    </div>
                    <p x-show="message" :class="messageType === 'success' ? 'text-emerald-500' : 'text-red-500'" class="text-[10px] mt-1" x-text="message"></p>
                </div>

                {{-- Price Details --}}
                <div class="space-y-2 p-4 rounded-xl bg-surface-100 dark:bg-surface-800">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-surface-500">قیمت واحد</span>
                        <span class="font-medium text-surface-900 dark:text-white" :class="couponApplied ? 'line-through opacity-50' : ''">{{ number_format($finalPrice) }} ت</span>
                    </div>
                    <div x-show="couponApplied" class="flex items-center justify-between text-sm text-emerald-500">
                        <span>تخفیف</span>
                        <span class="font-medium" x-text="'- ' + Number(discount).toLocaleString() + ' ت'"></span>
                    </div>
                    <div class="flex items-center justify-between border-t border-surface-200 dark:border-surface-700 pt-2 mt-2">
                        <span class="font-bold text-surface-900 dark:text-white">مبلغ نهایی</span>
                        <span class="text-xl font-bold text-primary-500" x-text="Number(finalPrice).toLocaleString() + ' ت'"></span>
                    </div>
                </div>

                {{-- Wallet Balance --}}
                <div class="flex items-center justify-between p-4 rounded-xl" :class="walletBalance >= finalPrice ? 'bg-emerald-500/10 border border-emerald-500/20' : 'bg-red-500/10 border border-red-500/20'" x-data="{ walletBalance: {{ $wallet->balance }} }">
                    <span class="text-sm" :class="walletBalance >= finalPrice ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500'">موجودی کیف پول</span>
                    <span class="font-bold" :class="walletBalance >= finalPrice ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500'">
                        {{ number_format($wallet->balance) }} ت
                    </span>
                </div>

                <div x-show="{{ $wallet->balance }} < finalPrice" class="text-center text-sm text-surface-500">
                    موجودی کافی ندارید.
                    <a href="{{ route('wallet') }}" class="text-primary-500 hover:underline">شارژ کیف پول</a>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    <a href="{{ url()->previous() }}" class="btn-secondary flex-1 justify-center">
                        انصراف
                    </a>
                    <form action="{{ route('purchase.submit') }}" method="POST" class="flex-1" x-show="{{ $wallet->balance }} >= finalPrice">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <input type="hidden" name="coupon_code" :value="couponCode">
                        <button type="submit" class="btn-primary w-full justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            خرید کن
                        </button>
                    </form>
                    <a href="{{ route('wallet') }}" class="btn-primary flex-1 justify-center gap-2" x-show="{{ $wallet->balance }} < finalPrice">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        شارژ کیف پول
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>
