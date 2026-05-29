<x-layouts.app title="خرید اشتراک">
    <div class="p-4 lg:p-8 max-w-lg mx-auto space-y-6" x-data="{ 
        originalPrice: {{ $plan->price }},
        finalPrice: {{ $plan->price }},
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
                    category: 'plans'
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
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center">خرید اشتراک</h1>

        <div class="glass-card rounded-2xl p-6">
            <div class="text-center mb-6">
                <h2 class="text-lg font-bold text-surface-900 dark:text-white">{{ $plan->name_fa }}</h2>
                <div class="flex flex-col items-center mt-2">
                    <p class="text-3xl font-extrabold text-primary-500" x-text="Number(finalPrice).toLocaleString() + ' تومان'"></p>
                    <p x-show="couponApplied" class="text-sm text-surface-400 line-through mt-1">{{ number_format($plan->price) }} تومان</p>
                </div>
                <p class="text-sm text-surface-500 mt-1">{{ $plan->duration_days }} روز</p>
            </div>

            <ul class="space-y-2 mb-6">
                @foreach($plan->features ?? [] as $feature)
                <li class="flex items-center gap-2 text-sm text-surface-600 dark:text-surface-400">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    {{ $feature }}
                </li>
                @endforeach
            </ul>

            {{-- Coupon Input --}}
            <div class="mb-6 p-4 rounded-xl bg-surface-100 dark:bg-surface-800/50 space-y-2">
                <label class="text-xs font-medium text-surface-500">کد تخفیف دارید؟</label>
                <div class="flex gap-2">
                    <input type="text" x-model="couponCode" :disabled="couponApplied" placeholder="کد تخفیف را وارد کنید..." class="flex-1 bg-white dark:bg-surface-800 border-none rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-primary-500 disabled:opacity-50">
                    <button @click="applyCoupon" :disabled="loading || !couponCode || couponApplied" class="btn-primary !px-4 !py-2 !text-xs whitespace-nowrap">
                        <span x-show="!loading">اعمال</span>
                        <span x-show="loading">...</span>
                    </button>
                </div>
                <p x-show="message" :class="messageType === 'success' ? 'text-emerald-500' : 'text-red-500'" class="text-[10px] mt-1" x-text="message"></p>
            </div>

            <form action="{{ route('subscription.pay') }}" method="POST">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                <input type="hidden" name="coupon_code" :value="couponCode">
                <button type="submit" class="btn-primary w-full">پرداخت با زرین‌پال</button>
            </form>
        </div>
    </div>
</x-layouts.app>
