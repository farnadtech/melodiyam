<x-layouts.app title="پنل هنرمند - {{ $artist->display_name }}">
    <div class="p-4 lg:p-8 space-y-8">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <img src="{{ $artist->getAvatarUrl() }}" alt="" class="w-16 h-16 rounded-full object-cover">
            <div>
                <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">{{ $artist->display_name }}</h1>
                <p class="text-sm text-surface-500">پنل هنرمند</p>
            </div>
        </div>

        {{-- Stats --}}
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

        {{-- Actions --}}
        <div class="flex flex-wrap gap-3">
            <a href="/artist/tracks" wire:navigate class="btn-ghost">مدیریت آهنگ‌ها</a>
            <a href="/artist/albums" wire:navigate class="btn-ghost">مدیریت آلبوم‌ها</a>
            <a href="/artist/analytics" wire:navigate class="btn-ghost">آمار و تحلیل</a>
        </div>

        {{-- Welcome --}}
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-2">خوش آمدید، {{ $artist->display_name }}!</h2>
            <p class="text-surface-500">این پنل مخصوص مدیریت آثار شماست. از منوی بالا می‌توانید آهنگ‌ها و آلبوم‌های خود را مدیریت کنید.</p>
        </div>
    </div>
</x-layouts.app>
