<x-layouts.app title="آلبوم‌های من">
    <div class="p-4 lg:p-8 space-y-6">
        <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">آلبوم‌های من</h1>
        @if($albums && $albums->isNotEmpty())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($albums as $album)
            <div class="glass-card rounded-2xl p-4">
                <div class="aspect-square rounded-xl overflow-hidden mb-3"><img src="{{ $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/default-cover.png') }}" class="w-full h-full object-cover" alt=""></div>
                <p class="font-medium text-surface-900 dark:text-surface-100 truncate text-sm">{{ $album->title }}</p>
                <p class="text-xs text-surface-400">{{ $album->tracks_count }} آهنگ</p>
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $albums->links() }}</div>
        @else
        <div class="text-center py-16"><p class="text-surface-500">هنوز آلبومی ندارید</p></div>
        @endif
    </div>
</x-layouts.app>
