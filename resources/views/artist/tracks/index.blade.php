<x-layouts.app title="آهنگ‌های من">
    <div class="p-4 lg:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آهنگ‌های من</h1>
            <a href="{{ route('artist.tracks.create') }}" wire:navigate class="btn-primary text-sm">+ آپلود آهنگ جدید</a>
        </div>

        @if(session('success'))
        <div class="glass-card rounded-xl p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-sm text-emerald-700 dark:text-emerald-400">
            {{ session('success') }}
        </div>
        @endif

        @if($tracks && $tracks->isNotEmpty())
        <div class="divide-y divide-surface-200 dark:divide-surface-800 glass-card rounded-2xl overflow-hidden">
            @foreach($tracks as $track)
            <div class="flex items-center gap-4 px-5 py-4 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                    <img src="{{ $track->getCoverUrl() }}" class="w-full h-full object-cover" alt="">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-surface-900 dark:text-surface-100 truncate">{{ $track->title }}</p>
                    <p class="text-xs text-surface-400">{{ $track->album->title ?? 'بدون آلبوم' }} · {{ gmdate('i:s', $track->duration) }}</p>
                </div>
                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $track->status === 'published' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-surface-100 text-surface-500 dark:bg-surface-700 dark:text-surface-400' }}">
                    {{ $track->status === 'published' ? 'منتشر' : 'پیش‌نویس' }}
                </span>
                @if($track->is_for_sale && $track->price)
                <span class="text-xs px-2.5 py-1 rounded-full bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400 font-medium">
                    {{ number_format($track->price) }} ت
                </span>
                @endif
                <span class="text-xs text-surface-400 hidden sm:block">{{ number_format($track->play_count) }} پخش</span>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('artist.tracks.edit', $track) }}" wire:navigate
                       class="p-2 rounded-lg text-surface-400 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors" title="ویرایش">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form method="POST" action="{{ route('artist.tracks.destroy', $track) }}"
                          onsubmit="return confirm('آهنگ «{{ $track->title }}» حذف شود؟')" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg text-surface-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors" title="حذف">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $tracks->links() }}</div>
        @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303"/></svg>
            <p class="text-surface-500 mb-4">هنوز آهنگی آپلود نکرده‌اید</p>
            <a href="{{ route('artist.tracks.create') }}" wire:navigate class="btn-primary">اولین آهنگ را آپلود کنید</a>
        </div>
        @endif
    </div>
</x-layouts.app>
