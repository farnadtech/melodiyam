<x-layouts.app title="آهنگ‌های من">
    <div class="p-4 lg:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آهنگ‌های من</h1>
            <a href="{{ route('artist.tracks.create') }}" wire:navigate class="btn-primary text-sm">آپلود آهنگ جدید</a>
        </div>
        @if($tracks && $tracks->isNotEmpty())
        <div class="divide-y divide-surface-200 dark:divide-surface-800 glass-card rounded-2xl overflow-hidden">
            @foreach($tracks as $track)
            <div class="flex items-center gap-4 px-5 py-4">
                <div class="w-12 h-12 rounded-lg overflow-hidden"><img src="{{ $track->getCoverUrl() }}" class="w-full h-full object-cover" alt=""></div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-surface-900 dark:text-surface-100 truncate">{{ $track->title }}</p>
                    <p class="text-xs text-surface-400">{{ $track->album->title ?? 'بدون آلبوم' }}</p>
                </div>
                <span class="badge {{ $track->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-surface-100 text-surface-500' }} text-xs px-2 py-1 rounded-full">
                    {{ $track->status === 'published' ? 'منتشر' : 'پیش‌نویس' }}
                </span>
                <span class="text-sm text-surface-400">{{ number_format($track->play_count) }} پخش</span>
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $tracks->links() }}</div>
        @else
        <div class="text-center py-16"><p class="text-surface-500">هنوز آهنگی آپلود نکرده‌اید</p></div>
        @endif
    </div>
</x-layouts.app>
