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
                    @php
                        $dIsPremiumOnly = (bool) $track->is_premium_only;
                        $dIsPremiumUser = auth()->user()?->isPremium() ?? false;
                        $dPremiumPreview = $dIsPremiumOnly && !$dIsPremiumUser
                            ? (int) \App\Models\Setting::get('premium_preview_seconds', 30)
                            : 0;
                        $dIsPaid = !$dIsPremiumOnly && $track->is_for_sale && $track->price;
                        $dPreview = $track->preview_seconds ?? 0;
                        $dCanPlay = !$dIsPaid && (!$dIsPremiumOnly || $dIsPremiumUser);
                        $dPurchaseUrl = route('purchase', ['type' => 'track', 'id' => $track->id]);
                        $trackUrl = route('track.show', $track);
                        $dArtistUrl = $track->artist ? route('artist.show', $track->artist->slug) : '';
                    @endphp
                    <div class="glass-card rounded-2xl p-4 hover:scale-105 transition-transform group relative">
                        <div class="aspect-square rounded-xl overflow-hidden mb-3 bg-surface-200 dark:bg-surface-700 relative">
                            <img src="{{ $track->cover_image ? asset('storage/'.$track->cover_image) : asset('images/default-cover.png') }}"
                                alt="{{ $track->title }}" class="w-full h-full object-cover">
                            @if($dIsPremiumOnly)
                            <div class="absolute top-2 left-2 bg-purple-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">پریمیوم</div>
                            @elseif($dIsPaid)
                            <div class="absolute top-2 left-2 bg-primary-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10">
                                {{ number_format($track->discount_price ?: $track->price) }} ت
                            </div>
                            @endif
                            {{-- Play button overlay centered on cover --}}
                            <button type="button"
                                x-data
                                @click.stop="@if($dIsPremiumOnly && !$dIsPremiumUser)$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ $trackUrl }}', artist_url: '{{ $dArtistUrl }}', duration: {{ $track->duration }}, previewSeconds: {{ $dPremiumPreview }}, canPlay: false, isPremium: true, purchaseUrl: '{{ route('premium') }}' })@elseif($dIsPaid && $dPreview == 0)$store.player.showPurchaseModal({ title: '{{ e($track->title) }}', price: {{ $track->discount_price ?: $track->price }}, discountPrice: {{ $track->discount_price ?? 'null' }}, purchaseUrl: '{{ $dPurchaseUrl }}' })@else$store.player.play({ id: {{ $track->id }}, title: '{{ e($track->title) }}', artist: '{{ e($track->artist->display_name ?? '') }}', url: '{{ $track->getStreamUrl() }}', cover: '{{ $track->getCoverUrl() }}', cover_page: '{{ $trackUrl }}', artist_url: '{{ $dArtistUrl }}', duration: {{ $track->duration }}, previewSeconds: {{ $dPreview }}, canPlay: {{ $dCanPlay ? 'true' : 'false' }}, price: {{ $track->discount_price ?: ($track->price ?? 0) }}, discountPrice: {{ $track->discount_price ?? 'null' }}, purchaseUrl: '{{ $dPurchaseUrl }}' })@endif"
                                class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity z-20">
                                @if($dIsPaid && $dPreview == 0)
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                @else
                                <svg class="w-14 h-14 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                @endif
                            </button>
                        </div>
                        <a href="{{ $trackUrl }}" wire:navigate class="block">
                            <p class="font-medium text-surface-900 dark:text-white text-sm truncate hover:text-primary-500 transition-colors">{{ $track->title }}</p>
                            <p class="text-xs text-surface-500 truncate mt-1">{{ $track->artist->display_name ?? '' }}</p>
                        </a>
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
