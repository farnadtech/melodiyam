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
            <div class="flex items-center gap-1 mb-1">
                @if($album->is_featured)
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-amber-400/20 text-amber-600 dark:text-amber-400 leading-none">ویژه</span>
                @endif
                @if($album->is_explicit)
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-red-500/10 text-red-500 border border-red-500/20 leading-none">18+</span>
                @endif
            </div>
            <p class="text-sm font-medium text-surface-900 dark:text-surface-100 truncate hover:text-primary-500 transition-colors">
                {{ $album->title }}
            </p>
            <p class="text-xs text-surface-500 dark:text-surface-400 truncate mt-0.5">
                {{ $album->artist->display_name ?? '' }} · {{ $album->release_date ? \App\Helpers\Jalali::format($album->release_date, 'Y') : '' }}
            </p>
        </div>
    </a>
</div>
