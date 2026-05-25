<div class="music-card" x-data>
    <div class="music-card-cover">
        <img
            src="{{ $track->getCoverUrl() }}"
            alt="{{ $track->title }}"
            class="w-full h-full object-cover"
            loading="lazy"
        >
        <div class="play-button-overlay">
            <button
                @click="$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', duration: {{ $track->duration }} })"
                class="w-12 h-12 rounded-full bg-primary-500 hover:bg-primary-400 flex items-center justify-center shadow-lg shadow-primary-500/40 hover:scale-110 transition-all"
            >
                <svg class="w-5 h-5 text-white mr-[-2px]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="mt-3 min-w-0">
        <a href="{{ route('track.show', $track) }}" wire:navigate class="block text-sm font-medium text-surface-900 dark:text-surface-100 truncate hover:text-primary-500 transition-colors">
            {{ $track->title }}
        </a>
        <a href="{{ route('artist.show', $track->artist ?? '') }}" wire:navigate class="block text-xs text-surface-500 dark:text-surface-400 truncate mt-0.5 hover:text-primary-500 transition-colors">
            {{ $track->artist->display_name ?? 'نامشخص' }}
        </a>
    </div>
</div>
