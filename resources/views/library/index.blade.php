<x-layouts.app title="کتابخانه">
    <div class="p-4 lg:p-8 space-y-8">
        <h1 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white">کتابخانه من</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('library.liked') }}" wire:navigate class="glass-card rounded-2xl p-6 flex items-center gap-4 hover:scale-[1.02] transition-transform">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div>
                    <p class="font-bold text-surface-900 dark:text-white">آهنگ‌های مورد علاقه</p>
                    <p class="text-sm text-surface-500">لایک‌شده‌های شما</p>
                </div>
            </a>

            <a href="{{ route('library.playlists') }}" wire:navigate class="glass-card rounded-2xl p-6 flex items-center gap-4 hover:scale-[1.02] transition-transform">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                </div>
                <div>
                    <p class="font-bold text-surface-900 dark:text-white">پلی‌لیست‌ها</p>
                    <p class="text-sm text-surface-500">مجموعه‌های شما</p>
                </div>
            </a>

            <a href="{{ route('library.history') }}" wire:navigate class="glass-card rounded-2xl p-6 flex items-center gap-4 hover:scale-[1.02] transition-transform">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="font-bold text-surface-900 dark:text-white">تاریخچه</p>
                    <p class="text-sm text-surface-500">اخیراً پخش‌شده</p>
                </div>
            </a>
        </div>
    </div>
</x-layouts.app>
