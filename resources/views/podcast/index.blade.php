<x-layouts.app title="پادکست‌ها">
    <div class="p-4 lg:p-8 space-y-8">
        <div>
            <h1 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white">پادکست‌ها</h1>
            <p class="text-surface-500 mt-1">پادکست‌های محبوب فارسی</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($podcasts as $podcast)
            <a href="{{ route('podcast.show', $podcast) }}" wire:navigate class="music-card">
                <div class="music-card-cover rounded-xl">
                    <img src="{{ $podcast->cover_image ? asset('storage/' . $podcast->cover_image) : asset('images/default-cover.png') }}" alt="{{ $podcast->title }}" class="w-full h-full object-cover" loading="lazy">
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate">{{ $podcast->title }}</p>
                    <p class="text-xs text-surface-400 truncate mt-0.5">{{ $podcast->artist->display_name ?? '' }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-6">{{ $podcasts->links() }}</div>
    </div>
</x-layouts.app>
