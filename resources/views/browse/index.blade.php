@php
    $isFiltered   = !empty($activeGenres) || (isset($sortBy) && $sortBy !== 'play_count');
    $activeGenreModels = $isFiltered && !empty($activeGenres)
        ? \App\Models\Genre::whereIn('slug', $activeGenres)->get()->keyBy('slug')
        : collect();

    $sortLabels = [
        'play_count'   => 'پرشنیده‌ترین',
        'release_date' => 'جدیدترین',
        'created_at'   => 'تازه‌اضافه‌شده',
    ];
    $sortLabel = $sortLabels[$sortBy ?? 'play_count'] ?? 'پرشنیده‌ترین';

    if ($isFiltered) {
        $genreNames = $activeGenreModels->map(fn($g) => $g->name_fa)->values()->implode('، ');
        $pageTitle    = $genreNames ?: 'همه ژانرها';
        $pageSubtitle = $sortLabel . ($genreNames ? ' در ' . $genreNames : '');
    }
@endphp
<x-layouts.app :title="$isFiltered ? ($pageTitle ?? 'نتایج') : 'مرور موسیقی'">
    <div class="p-4 lg:p-8 space-y-8">

        @if($isFiltered)
            {{-- Filtered view header --}}
            <div class="flex items-center gap-3 flex-wrap">
                <a href="{{ route('browse') }}" wire:navigate
                   class="flex items-center gap-1 text-sm text-surface-500 hover:text-primary-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    بازگشت به مرور
                </a>
                <span class="text-surface-300 dark:text-surface-600">/</span>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white">
                        {{ $pageTitle }}
                    </h1>
                    <p class="text-surface-500 mt-1 text-sm">{{ $pageSubtitle }}</p>
                </div>
            </div>

            {{-- Active genre badges --}}
            @if($activeGenreModels->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                @foreach($activeGenreModels as $slug => $genre)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium text-white"
                      style="background-color: {{ $genre->color ?? '#6366f1' }}">
                    {{ $genre->name_fa }}
                </span>
                @endforeach
            </div>
            @endif

        @else
            {{-- Default browse header --}}
            <div>
                <h1 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white">مرور موسیقی</h1>
                <p class="text-surface-500 mt-1">ژانرها و محبوب‌ترین آهنگ‌ها را کشف کنید</p>
            </div>

            {{-- Genres Grid --}}
            <section>
                <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">ژانرها</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach($genres as $genre)
                        @include('components.genre-card', ['genre' => $genre])
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Tracks with infinite scroll --}}
        @php
            $initialTracks = $tracks->map(function($t) {
                $isPaid = $t->is_for_sale && $t->price;
                $previewSec = $t->preview_seconds ?? 0;
                return [
                    'id'             => $t->id,
                    'title'          => $t->title,
                    'artist'         => $t->artist?->display_name ?? $t->artist?->name,
                    'cover'          => $t->getCoverUrl(),
                    'url'            => $t->getStreamUrl(),
                    'cover_page'     => route('track.show', $t->slug),
                    'canPlay'        => !$isPaid,
                    'previewSeconds' => $previewSec,
                    'price'          => $t->discount_price ?: $t->price,
                    'purchaseUrl'    => route('purchase', ['type' => 'track', 'id' => $t->id]),
                    'isPaid'         => (bool)$isPaid,
                ];
            })->values()->toArray();
            $hasMore   = $tracks->hasMorePages();
            $nextPage  = 2;
            $apiUrl    = url()->current() . '/tracks.json?' . http_build_query(request()->except('page'));
        @endphp

        <section
            x-data="{
                tracks: {{ Js::from($initialTracks) }},
                hasMore: {{ $hasMore ? 'true' : 'false' }},
                loading: false,
                page: 2,
                apiUrl: '{{ $apiUrl }}',
                async loadMore() {
                    if (this.loading || !this.hasMore) return;
                    this.loading = true;
                    try {
                        const res = await fetch(this.apiUrl + '&page=' + this.page);
                        const data = await res.json();
                        this.tracks.push(...data.tracks);
                        this.hasMore = data.has_more;
                        this.page++;
                    } catch(e) {}
                    this.loading = false;
                },
                init() {
                    const sentinel = this.$refs.sentinel;
                    if (!sentinel) return;
                    const observer = new IntersectionObserver((entries) => {
                        if (entries[0].isIntersecting) this.loadMore();
                    }, { rootMargin: '200px' });
                    observer.observe(sentinel);
                }
            }"
        >
            @if(!$isFiltered)
            <h2 class="text-lg font-bold text-surface-900 dark:text-white mb-4">محبوب‌ترین آهنگ‌ها</h2>
            @endif

            <template x-if="tracks.length === 0 && !loading">
                <div class="text-center py-20 text-surface-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303m0 0v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 01-.99-3.467l2.31-.66A2.25 2.25 0 009 15.553z"/></svg>
                    <p>آهنگی یافت نشد</p>
                </div>
            </template>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <template x-for="track in tracks" :key="track.id">
                    <div class="group">
                        <div class="relative aspect-square rounded-xl overflow-hidden bg-surface-200 dark:bg-surface-800">
                            <img :src="track.cover" :alt="track.title"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center">
                                <button
                                    x-on:click.stop="track.isPremium
                                        ? $store.player.play({ id: track.id, title: track.title, artist: track.artist, cover: track.cover, url: track.url, canPlay: false, previewSeconds: track.previewSeconds, isPremium: true, purchaseUrl: track.purchaseUrl })
                                        : (track.isPaid && !track.previewSeconds
                                            ? $store.player.showPurchaseModal({ title: track.title, price: track.price, purchaseUrl: track.purchaseUrl })
                                            : $store.player.play({ id: track.id, title: track.title, artist: track.artist, cover: track.cover, url: track.url, canPlay: track.canPlay, previewSeconds: track.previewSeconds, price: track.price, purchaseUrl: track.purchaseUrl }))"
                                    :class="track.isPremium ? 'bg-purple-500 hover:bg-purple-400 shadow-purple-500/40' : 'bg-primary-500 hover:bg-primary-400'"
                                    class="opacity-0 group-hover:opacity-100 transition w-11 h-11 rounded-full flex items-center justify-center shadow-lg">
                                    <template x-if="track.isPaid && !track.previewSeconds && !track.isPremium">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </template>
                                    <template x-if="!(track.isPaid && !track.previewSeconds && !track.isPremium)">
                                        <svg class="w-5 h-5 text-white mr-[-2px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </template>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 min-w-0">
                            <a :href="track.cover_page" @click.prevent="Livewire.navigate(track.cover_page)" class="block text-sm font-medium text-surface-900 dark:text-white truncate hover:text-primary-500 transition-colors" x-text="track.title"></a>
                            <div class="flex items-center justify-between mt-0.5">
                                <p class="text-xs text-surface-500 truncate" x-text="track.artist"></p>
                                <span x-show="track.isPremium" class="whitespace-nowrap mr-1 text-[10px] font-bold px-1.5 py-0.5 rounded bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 leading-none">پریمیوم</span>
                                <span x-show="track.isPaid && !track.isPremium" class="whitespace-nowrap mr-1 text-xs font-bold text-primary-500" x-text="track.price ? track.price.toLocaleString('fa-IR') + ' ت' : ''"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Loading spinner --}}
            <div x-show="loading" class="flex justify-center py-8">
                <svg class="w-8 h-8 animate-spin text-primary-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
            </div>

            {{-- Sentinel element for IntersectionObserver --}}
            <div x-ref="sentinel" class="h-4"></div>
        </section>
    </div>
</x-layouts.app>
