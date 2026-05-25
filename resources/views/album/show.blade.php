<x-layouts.app :title="$album->title">
    <div class="p-4 lg:p-8 space-y-8">

        {{-- Album Header --}}
        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 mx-auto md:mx-0">
                <img src="{{ $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/default-cover.png') }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col justify-end text-center md:text-right">
                <p class="text-xs font-medium text-surface-500 uppercase tracking-wider mb-2">{{ $album->type === 'single' ? 'سینگل' : 'آلبوم' }}</p>
                <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-surface-900 dark:text-white mb-3">{{ $album->title }}</h1>
                <div class="flex flex-wrap items-center gap-2 justify-center md:justify-start text-sm text-surface-500">
                    <a href="{{ route('artist.show', $album->artist ?? '') }}" wire:navigate class="font-medium text-surface-900 dark:text-white hover:text-primary-500">
                        {{ $album->artist->display_name ?? '' }}
                    </a>
                    @if($album->release_date)
                    <span>·</span>
                    <span>{{ $album->release_date->year }}</span>
                    @endif
                    <span>·</span>
                    <span>{{ $album->tracks->count() }} آهنگ</span>
                    <span>·</span>
                    <span>{{ number_format($album->play_count) }} پخش</span>
                </div>
            </div>
        </div>

        {{-- Track List --}}
        <section>
            <div class="divide-y divide-surface-200 dark:divide-surface-800 rounded-2xl overflow-hidden">
                @foreach($album->tracks as $track)
                <div class="flex items-center gap-4 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors group" x-data>
                    <span class="text-sm text-surface-400 w-6 text-center">{{ $track->track_number }}</span>
                    <button
                        @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($album->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/default-cover.png') }}', duration: {{ $track->duration }} })"
                        class="opacity-0 group-hover:opacity-100 transition-opacity"
                    >
                        <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('track.show', $track) }}" wire:navigate class="text-sm font-medium text-surface-900 dark:text-surface-100 hover:text-primary-500 truncate block">{{ $track->title }}</a>
                        <p class="text-xs text-surface-400 truncate">{{ $track->artist->display_name ?? $album->artist->display_name ?? '' }}</p>
                    </div>
                    <span class="text-xs text-surface-400">{{ $track->formattedDuration() }}</span>
                    <span class="text-xs text-surface-400">{{ number_format($track->play_count) }}</span>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</x-layouts.app>
