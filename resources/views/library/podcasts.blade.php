<x-layouts.app :title="'پادکست‌های من'">
    <div class="p-4 lg:p-8 space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-surface-900 dark:text-white">پادکست‌های من</h1>
        </div>

        @if($podcasts->isEmpty())
        <div class="text-center py-16">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-surface-100 dark:bg-surface-800 flex items-center justify-center">
                <svg class="w-10 h-10 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
            </div>
            <p class="text-surface-500 dark:text-surface-400 mb-4">هنوز پادکستی دنبال نکرده‌اید</p>
            <a href="{{ route('podcasts.index') }}" wire:navigate class="btn-primary inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                کشف پادکست‌ها
            </a>
        </div>
        @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($podcasts as $podcast)
            <a href="{{ route('podcast.show', $podcast) }}" wire:navigate class="group">
                <div class="relative aspect-square rounded-xl overflow-hidden mb-3">
                    <img src="{{ $podcast->cover_image ? asset('storage/' . $podcast->cover_image) : asset('images/default-cover.png') }}" 
                         alt="{{ $podcast->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <h3 class="text-sm font-medium text-surface-900 dark:text-white truncate group-hover:text-primary-500 transition-colors">{{ $podcast->title }}</h3>
                <p class="text-xs text-surface-500 truncate">{{ $podcast->artist->display_name ?? '' }}</p>
                <p class="text-xs text-surface-400 mt-1">{{ number_format($podcast->subscribers_count) }} دنبال‌کننده</p>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</x-layouts.app>
