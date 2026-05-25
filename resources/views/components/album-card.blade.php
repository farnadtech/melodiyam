<div class="music-card">
    <a href="{{ route('album.show', $album) }}" wire:navigate>
        <div class="music-card-cover">
            <img
                src="{{ $album->cover_image ? asset('storage/' . $album->cover_image) : asset('images/default-cover.png') }}"
                alt="{{ $album->title }}"
                class="w-full h-full object-cover"
                loading="lazy"
            >
        </div>
        <div class="mt-3 min-w-0">
            <p class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate hover:text-primary-500 transition-colors">
                {{ $album->title }}
            </p>
            <p class="text-xs text-surface-500 dark:text-surface-400 truncate mt-0.5">
                {{ $album->artist->display_name ?? '' }} · {{ $album->release_date?->year }}
            </p>
        </div>
    </a>
</div>
