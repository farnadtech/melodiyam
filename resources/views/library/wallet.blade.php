<x-layouts.app title="کیف پول">
    <div class="p-4 lg:p-8 space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">کیف پول</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="glass-card rounded-2xl p-6 gradient-primary text-white">
                <p class="text-sm opacity-80 mb-1">موجودی کیف پول</p>
                <p class="text-4xl font-bold">۰ تومان</p>
                <p class="text-sm opacity-70 mt-2">{{ auth()->user()->name }}</p>
            </div>

            <div class="glass-card rounded-2xl p-6 space-y-4">
                <h2 class="font-bold text-surface-900 dark:text-white">شارژ کیف پول</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach([50000, 100000, 200000, 500000] as $amount)
                        <button class="btn-ghost py-3 rounded-xl text-sm font-medium">
                            {{ number_format($amount) }} تومان
                        </button>
                    @endforeach
                </div>
                <a href="{{ url('/premium') }}" wire:navigate class="btn-primary w-full text-center block">خرید اشتراک پریمیوم</a>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <h2 class="font-bold text-surface-900 dark:text-white mb-4">تاریخچه تراکنش‌ها</h2>
            <div class="text-center py-8">
                <p class="text-surface-500">تراکنشی وجود ندارد</p>
            </div>
        </div>
    </div>
</x-layouts.app>
