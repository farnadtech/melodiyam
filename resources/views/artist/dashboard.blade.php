<x-layouts.app title="پنل هنرمند">
    <div class="p-4 lg:p-8 space-y-8">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">پنل هنرمند</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="glass-card rounded-2xl p-5">
                <p class="text-sm text-surface-500">کل پخش‌ها</p>
                <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ number_format($totalStreams) }}</p>
            </div>
            <div class="glass-card rounded-2xl p-5">
                <p class="text-sm text-surface-500">آهنگ‌ها</p>
                <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ $totalTracks }}</p>
            </div>
            <div class="glass-card rounded-2xl p-5">
                <p class="text-sm text-surface-500">آلبوم‌ها</p>
                <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ $totalAlbums }}</p>
            </div>
            <div class="glass-card rounded-2xl p-5">
                <p class="text-sm text-surface-500">دنبال‌کننده‌ها</p>
                <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ number_format($followers) }}</p>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('artist.tracks') }}" wire:navigate class="btn-primary">مدیریت آهنگ‌ها</a>
            <a href="{{ route('artist.albums') }}" wire:navigate class="btn-ghost">مدیریت آلبوم‌ها</a>
            <a href="{{ route('artist.analytics') }}" wire:navigate class="btn-ghost">آمار و تحلیل</a>
        </div>
    </div>
</x-layouts.app>
