<x-layouts.app title="پنل هنرمند">
<div class="p-4 lg:p-8 space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-4">
            <img src="{{ $artist->getAvatarUrl() }}" alt="" class="w-16 h-16 rounded-full object-cover ring-2 ring-primary-200 dark:ring-primary-800">
            <div>
                <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">{{ $artist->display_name }}</h1>
                <p class="text-sm text-surface-500">پنل هنرمند</p>
            </div>
        </div>
        <a href="{{ route('artist.show', $artist) }}" wire:navigate
           class="text-sm text-primary-500 hover:underline flex items-center gap-1">
            مشاهده پروفایل عمومی
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>

    @if(session('success'))
    <div class="glass-card rounded-xl p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-sm text-emerald-700 dark:text-emerald-400">
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-surface-500 mb-1">کل پخش‌ها</p>
            <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($totalStreams) }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-surface-500 mb-1">آهنگ‌ها</p>
            <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ $totalTracks }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-surface-500 mb-1">آلبوم‌ها</p>
            <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ $totalAlbums }}</p>
        </div>
        <div class="glass-card rounded-2xl p-5">
            <p class="text-xs text-surface-500 mb-1">دنبال‌کننده‌ها</p>
            <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($followers) }}</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ route('artist.tracks.create') }}" wire:navigate
           class="glass-card rounded-2xl p-5 flex items-center gap-4 hover:ring-2 hover:ring-primary-300 dark:hover:ring-primary-700 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors">
                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <p class="font-semibold text-surface-900 dark:text-white">آپلود آهنگ جدید</p>
                <p class="text-xs text-surface-500 mt-0.5">فایل موسیقی را آپلود کنید</p>
            </div>
        </a>

        <a href="{{ route('artist.albums.create') }}" wire:navigate
           class="glass-card rounded-2xl p-5 flex items-center gap-4 hover:ring-2 hover:ring-emerald-300 dark:hover:ring-emerald-700 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-800/50 transition-colors">
                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <p class="font-semibold text-surface-900 dark:text-white">آلبوم جدید</p>
                <p class="text-xs text-surface-500 mt-0.5">یک آلبوم بسازید</p>
            </div>
        </a>

        <a href="{{ route('artist.analytics') }}" wire:navigate
           class="glass-card rounded-2xl p-5 flex items-center gap-4 hover:ring-2 hover:ring-violet-300 dark:hover:ring-violet-700 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center flex-shrink-0 group-hover:bg-violet-200 dark:group-hover:bg-violet-800/50 transition-colors">
                <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <div>
                <p class="font-semibold text-surface-900 dark:text-white">آمار و درآمد</p>
                <p class="text-xs text-surface-500 mt-0.5">مشاهده فروش و پخش</p>
            </div>
        </a>
    </div>

    {{-- Management Links --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-surface-900 dark:text-white">آهنگ‌های من</h2>
                <a href="{{ route('artist.tracks') }}" wire:navigate class="text-xs text-primary-500 hover:underline">مشاهده همه</a>
            </div>
            <p class="text-3xl font-bold text-surface-900 dark:text-white">{{ $totalTracks }}</p>
            <p class="text-xs text-surface-500 mt-1">آهنگ آپلود شده</p>
            <a href="{{ route('artist.tracks') }}" wire:navigate
               class="mt-4 flex items-center gap-2 text-sm text-surface-600 dark:text-surface-400 hover:text-primary-500 transition-colors">
                <span>مدیریت آهنگ‌ها</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-surface-900 dark:text-white">آلبوم‌های من</h2>
                <a href="{{ route('artist.albums') }}" wire:navigate class="text-xs text-primary-500 hover:underline">مشاهده همه</a>
            </div>
            <p class="text-3xl font-bold text-surface-900 dark:text-white">{{ $totalAlbums }}</p>
            <p class="text-xs text-surface-500 mt-1">آلبوم ساخته شده</p>
            <a href="{{ route('artist.albums') }}" wire:navigate
               class="mt-4 flex items-center gap-2 text-sm text-surface-600 dark:text-surface-400 hover:text-primary-500 transition-colors">
                <span>مدیریت آلبوم‌ها</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

</div>
</x-layouts.app>
