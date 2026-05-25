<x-layouts.app title="خرید اشتراک">
    <div class="p-4 lg:p-8 max-w-lg mx-auto space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white text-center">خرید اشتراک</h1>

        <div class="glass-card rounded-2xl p-6">
            <div class="text-center mb-6">
                <h2 class="text-lg font-bold text-surface-900 dark:text-white">{{ $plan->name_fa }}</h2>
                <p class="text-3xl font-extrabold text-primary-500 mt-2">{{ number_format($plan->price) }} <span class="text-sm text-surface-500">تومان</span></p>
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

            <form action="{{ route('subscription.pay') }}" method="POST">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                <button type="submit" class="btn-primary w-full">پرداخت با زرین‌پال</button>
            </form>
        </div>
    </div>
</x-layouts.app>
