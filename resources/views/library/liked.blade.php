<x-layouts.app title="آهنگ‌های مورد علاقه">
    <div class="p-4 lg:p-8 space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آهنگ‌های مورد علاقه</h1>
        @if($tracks->isNotEmpty())
        <div class="divide-y divide-surface-200 dark:divide-surface-800">
            @foreach($tracks as $like)
                @if($like->likeable)
                <div class="flex items-center gap-4 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                    <div class="w-10 h-10 rounded-lg overflow-hidden"><img src="{{ $like->likeable->getCoverUrl() }}" class="w-full h-full object-cover" alt=""></div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('track.show', $like->likeable) }}" wire:navigate class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate block">{{ $like->likeable->title }}</a>
                        <p class="text-xs text-surface-400 truncate">{{ $like->likeable->artist->display_name ?? '' }}</p>
                    </div>
                    <span class="text-xs text-surface-400">{{ $like->likeable->formattedDuration() }}</span>
                </div>
                @endif
            @endforeach
        </div>
        <div class="mt-4">{{ $tracks->links() }}</div>
        @else
        <div class="text-center py-16"><p class="text-surface-500">هنوز آهنگی لایک نکرده‌اید</p></div>
        @endif
    </div>
</x-layouts.app>
