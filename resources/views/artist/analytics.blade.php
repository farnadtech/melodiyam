<x-layouts.app title="آمار و تحلیل">
    <div class="p-4 lg:p-8 space-y-8">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آمار و تحلیل</h1>

        @if($artist)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="glass-card rounded-2xl p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-surface-500">کل پخش‌ها</p>
                        <p class="text-xl font-bold text-surface-900 dark:text-white">{{ number_format($artist->total_streams) }}</p>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-surface-500">دنبال‌کننده‌ها</p>
                        <p class="text-xl font-bold text-surface-900 dark:text-white">{{ number_format($artist->followers_count) }}</p>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-surface-500">شنونده ماهانه</p>
                        <p class="text-xl font-bold text-surface-900 dark:text-white">{{ number_format($artist->monthly_listeners) }}</p>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-surface-500">موجودی</p>
                        <p class="text-xl font-bold text-surface-900 dark:text-white">{{ number_format($artist->balance ?? 0) }} <span class="text-xs text-surface-400">تومان</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">آمار تفصیلی</h2>
            <p class="text-surface-500 text-sm">نمودارهای تفصیلی آمار پخش و درآمد به زودی اضافه خواهد شد.</p>
        </div>
        @else
        <div class="text-center py-16"><p class="text-surface-500">پروفایل هنرمندی یافت نشد.</p></div>
        @endif
    </div>
</x-layouts.app>
