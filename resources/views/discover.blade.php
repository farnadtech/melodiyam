<x-layouts.app title="پیشنهاد ویژه">
    <div class="p-4 lg:p-8 pb-28 lg:pb-12 space-y-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-display font-bold text-surface-900 dark:text-white">
                    @if($isPersonalized)
                        پیشنهاد ویژه برای {{ auth()->user()->name ?? 'شما' }}
                    @else
                        کشف موسیقی
                    @endif
                </h1>
                <p class="text-surface-500 mt-1">
                    @if($isPersonalized)
                        بر اساس سلیقه موسیقی شما
                        @if(!empty($tasteProfile['genre_names']))
                            — {{ implode('، ', array_slice($tasteProfile['genre_names'], 0, 3)) }}
                        @endif
                    @else
                        موسیقی‌های جدید و هنرمندان محبوب را کشف کنید
                    @endif
                </p>
            </div>
            @if($isPersonalized && isset($generatedAt))
            <span class="text-xs text-surface-400 flex items-center gap-1 flex-shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                بروزرسانی: {{ $generatedAt->diffForHumans() }}
            </span>
            @endif
        </div>

        {{-- Recommended Tracks --}}
        @if($recommendedTracks->isNotEmpty())
        <section>
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                <h2 class="text-lg font-bold text-surface-900 dark:text-white">
                    @if($isPersonalized) آهنگ‌های پیشنهادی @else آهنگ‌های پرطرفدار @endif
                </h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($recommendedTracks as $rec)
                    @php $track = $rec['track']; $reason = $rec['reason'] ?? ''; @endphp
                    @include('discover._track-card', ['track' => $track, 'reason' => $reason, 'badge' => null])
                @endforeach
            </div>
        </section>
        @endif

        {{-- Recommended Albums --}}
        @if($recommendedAlbums->isNotEmpty())
        <section>
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                <h2 class="text-lg font-bold text-surface-900 dark:text-white">
                    @if($isPersonalized) آلبوم‌های پیشنهادی @else آلبوم‌های پرطرفدار @endif
                </h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                @foreach($recommendedAlbums as $rec)
                    @php $album = $rec['album']; $reason = $rec['reason'] ?? ''; @endphp
                    <a href="{{ route('album.show', $album) }}" wire:navigate
                       class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group cursor-pointer block relative">
                        <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
                            @php $albumCover = $album->getCoverUrl(); @endphp
                            <img src="{{ $albumCover }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-xl opacity-50 scale-110">
                            <img src="{{ $albumCover }}" alt="{{ $album->title }}" class="relative z-10 w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-20">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 5v14l11-7z"/></svg>
                            </div>
                            @if($album->is_for_sale && $album->price)
                            <div class="absolute top-2 left-2 bg-primary-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">
                                {{ number_format($album->discount_price ?? $album->price) }} ت
                            </div>
                            @endif
                        </div>
                        @if($reason)
                        <span class="absolute top-2 right-2 bg-surface-900/80 text-[10px] text-surface-200 px-2 py-0.5 rounded-full backdrop-blur-sm z-10 max-w-[70%] truncate">{{ $reason }}</span>
                        @endif
                        <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $album->title }}</p>
                        <p class="text-xs text-surface-500 truncate mt-0.5">{{ $album->artist->display_name ?? '' }}</p>
                        <p class="text-xs text-surface-400 mt-0.5">{{ $album->tracks_count ?? $album->tracks->count() }} آهنگ</p>
                    </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- Recommended Playlists --}}
        @if($recommendedPlaylists->isNotEmpty())
        <section>
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <h2 class="text-lg font-bold text-surface-900 dark:text-white">پلی‌لیست‌های پیشنهادی</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($recommendedPlaylists as $playlist)
                <a href="{{ route('playlist.show', $playlist) }}" wire:navigate
                   class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group cursor-pointer block">
                    <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-gradient-to-br from-primary-500/20 to-accent-500/20 dark:from-primary-500/10 dark:to-accent-500/10 relative flex items-center justify-center">
                        @if($playlist->cover_image)
                        <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="" class="absolute inset-0 w-full h-full object-cover">
                        @else
                        <svg class="w-12 h-12 text-primary-500/40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                        @endif
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-10">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                    <p class="font-medium text-surface-900 dark:text-white text-sm truncate">{{ $playlist->title }}</p>
                    <p class="text-xs text-surface-500 truncate mt-0.5">{{ $playlist->user->name ?? '' }}</p>
                    <p class="text-xs text-surface-400 mt-0.5">{{ $playlist->tracks_count ?? 0 }} آهنگ</p>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- Smart Playlists (Auto-generated for user) --}}
        @if(isset($smartPlaylists) && $smartPlaylists->isNotEmpty())
        <section>
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                <h2 class="text-lg font-bold text-surface-900 dark:text-white">پلی‌لیست‌های هوشمند شما</h2>
                <span class="text-xs text-surface-400 mr-2">هر هفته بروزرسانی می‌شود</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($smartPlaylists as $playlist)
                <a href="{{ route('playlist.show', $playlist) }}" wire:navigate
                   class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group cursor-pointer block relative overflow-hidden">
                    <div class="absolute top-2 right-2 bg-purple-500 text-white text-[9px] font-bold px-2 py-0.5 rounded-full z-20">هوشمند</div>
                    <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-gradient-to-br from-purple-500/30 to-pink-500/20 dark:from-purple-500/20 dark:to-pink-500/10 relative flex items-center justify-center">
                        @if($playlist->cover_image)
                        <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="" class="absolute inset-0 w-full h-full object-cover">
                        @else
                        <svg class="w-14 h-14 text-purple-400/50" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                        @endif
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-10">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                    <p class="font-bold text-surface-900 dark:text-white text-sm truncate">{{ $playlist->title }}</p>
                    <p class="text-xs text-surface-400 mt-1">{{ $playlist->tracks_count ?? 0 }} آهنگ • ساخته شده برای شما</p>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- Trending Now (always shown) --}}
        @if($trendingTracks->isNotEmpty())
        <section>
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.59 2.65.59 4.04 0 2.65-2.15 4.8-4.8 4.8z"/></svg>
                    <h2 class="text-lg font-bold text-surface-900 dark:text-white">پرطرفدارها</h2>
                </div>
                <a href="{{ route('browse', ['sort' => 'most_played']) }}" wire:navigate class="text-sm text-primary-500 hover:underline">مشاهده همه</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($trendingTracks->take(10) as $rec)
                    @php $track = $rec['track']; @endphp
                    @include('discover._track-card', ['track' => $track, 'reason' => 'پرطرفدار', 'badge' => '🔥'])
                @endforeach
            </div>
        </section>
        @endif

    </div>
</x-layouts.app>
