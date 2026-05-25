<div class="music-card">
    <a href="{{ route('playlist.show', $playlist) }}" wire:navigate>
        <div class="music-card-cover">
            <img
                src="{{ $playlist->cover_image ? asset('storage/' . $playlist->cover_image) : asset('images/default-playlist.png') }}"
                alt="{{ $playlist->title }}"
                class="w-full h-full object-cover"
                loading="lazy"
            >
            @if($playlist->is_sponsored)
            <div class="absolute top-2 right-2 px-2 py-0.5 rounded-full bg-amber-500/90 text-white text-[10px] font-medium">ویژه</div>
            @endif
        </div>
        <div class="mt-3 min-w-0">
            <p class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate hover:text-primary-500 transition-colors">
                {{ $playlist->title }}
            </p>
            <p class="text-xs text-surface-500 dark:text-surface-400 truncate mt-0.5">
                {{ $playlist->tracks_count }} آهنگ · {{ $playlist->user->name ?? '' }}
            </p>
        </div>
    </a>
</div>
