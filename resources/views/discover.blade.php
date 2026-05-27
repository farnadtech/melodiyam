<x-layouts.app title="کشف موسیقی">
    <div class="p-4 lg:p-8 space-y-10">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">کشف کن</h1>
            <p class="text-surface-500 mt-1">موسیقی‌های جدید و هنرمندان محبوب را کشف کنید</p>
        </div>

        {{-- New Releases --}}
        <section>
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">جدیدترین آهنگ‌ها</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($newReleases as $track)
                    <div class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group cursor-pointer"
                        x-data
                        x-on:click="$store.player.playTrack({
                            id: {{ $track->id }},
                            title: @js($track->title),
                            artist: @js($track->artist->display_name ?? ''),
                            cover: '{{ $track->cover_image ? asset('storage/'.$track->cover_image) : asset('images/default-cover.png') }}',
                            src: '{{ route('track.stream', $track) }}'
                        })"
                    >
                        <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
                            <img src="{{ $track->cover_image ? asset('storage/'.$track->cover_image) : asset('images/default-cover.png') }}"
                                alt="{{ $track->title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                        <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $track->title }}</p>
                        <p class="text-xs text-surface-500 truncate mt-1">{{ $track->artist->display_name ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Top Artists --}}
        <section>
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">هنرمندان محبوب</h2>
            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($topArtists as $artist)
                    <a href="{{ route('artist.show', $artist) }}" wire:navigate class="text-center hover:scale-105 transition-transform">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden mx-auto mb-2 bg-surface-200 dark:bg-surface-700">
                            @if($artist->user?->avatar)
                                <img src="{{ asset('storage/'.$artist->user->avatar) }}" alt="{{ $artist->display_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                        </div>
                        <p class="text-xs font-medium text-surface-900 dark:text-white truncate">{{ $artist->display_name }}</p>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- New Albums --}}
        @if($newAlbums->isNotEmpty())
        <section>
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">جدیدترین آلبوم‌ها</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                @foreach($newAlbums as $album)
                <a href="{{ route('album.show', $album) }}" wire:navigate
                   class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group cursor-pointer block">
                    <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
                        <img src="{{ $album->getCoverUrl() }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/>
                            </svg>
                        </div>
                        @if($album->is_for_sale && $album->price)
                        <div class="absolute top-2 left-2 bg-primary-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                            {{ number_format($album->discount_price ?? $album->price) }} ت
                        </div>
                        @endif
                    </div>
                    <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $album->title }}</p>
                    <p class="text-xs text-surface-500 truncate mt-0.5">{{ $album->artist->display_name ?? '' }}</p>
                    <p class="text-xs text-surface-400 mt-0.5">{{ $album->tracks_count ?? $album->tracks->count() }} آهنگ</p>
                </a>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</x-layouts.app>
