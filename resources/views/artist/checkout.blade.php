<x-layouts.app title="خرید اشتراک هنرمند">
    <div class="p-4 lg:p-8 max-w-lg mx-auto space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center">خرید اشتراک هنرمند</h1>

        <div class="glass-card rounded-2xl p-6">
            <div class="text-center mb-6">
                <h2 class="text-lg font-bold text-surface-900 dark:text-white">{{ $plan->name }}</h2>
                <p class="text-3xl font-extrabold text-primary-500 mt-2">{{ number_format($plan->price) }} <span class="text-sm text-surface-500">تومان</span></p>
                <p class="text-sm text-surface-500 mt-1">{{ $plan->duration_days }} روز اعتبار</p>
            </div>

            <ul class="space-y-2 mb-6">
                <li class="flex items-center gap-2 text-sm text-surface-600 dark:text-surface-400">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    {{ $plan->max_tracks == 0 ? 'آهنگ نامحدود' : 'تا ' . $plan->max_tracks . ' آهنگ' }}
                </li>
                <li class="flex items-center gap-2 text-sm text-surface-600 dark:text-surface-400">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    {{ $plan->max_albums == 0 ? 'آلبوم نامحدود' : 'تا ' . $plan->max_albums . ' آلبوم' }}
                </li>
                <li class="flex items-center gap-2 text-sm text-surface-600 dark:text-surface-400">
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    {{ $plan->max_storage_mb == 0 ? 'فضای نامحدود' : $plan->max_storage_mb . ' MB فضا' }}
                </li>
            </ul>

            <form action="{{ route('artist.subscription.pay') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                        ایمیل برای ارسال صورتحساب
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        required
                        class="w-full rounded-xl border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-800 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 text-surface-900 dark:text-surface-100"
                        placeholder="example@email.com"
                    >
                    @error('email')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full">پرداخت با زرین‌پال</button>
            </form>

            <p class="text-xs text-surface-400 text-center mt-4">
                پس از پرداخت، اشتراک شما بلافاصله فعال خواهد شد.
            </p>
        </div>

        <a href="{{ route('artist.plans') }}" class="text-sm text-surface-500 hover:text-primary-500 text-center block">
            ← بازگشت به لیست پلن‌ها
        </a>
    </div>
</x-layouts.app>
