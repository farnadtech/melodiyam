<x-layouts.app title="تاریخچه پخش">
    <div class="p-4 lg:p-8 space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">تاریخچه پخش</h1>
        @if($history->isNotEmpty())
        <div class="divide-y divide-surface-200 dark:divide-surface-800">
            @foreach($history as $item)
                @if($item->playable)
                <div class="flex items-center gap-4 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                    <div class="w-10 h-10 rounded-lg overflow-hidden"><img src="{{ method_exists($item->playable, 'getCoverUrl') ? $item->playable->getCoverUrl() : asset('images/default-cover.png') }}" class="w-full h-full object-cover" alt=""></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate">{{ $item->playable->title ?? '' }}</p>
                        <p class="text-xs text-surface-400">{{ $item->played_at?->diffForHumans() }}</p>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @else
        <div class="text-center py-16"><p class="text-surface-500">تاریخچه‌ای ندارید</p></div>
        @endif
    </div>
</x-layouts.app>
