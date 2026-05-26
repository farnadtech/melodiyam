@php
    $initialTracks = $tracks->map(fn($t) => [
        'id'         => $t->id,
        'title'      => $t->title,
        'artist'     => $t->artist?->display_name ?? $t->artist?->name,
        'cover'      => $t->getCoverUrl(),
        'url'        => $t->getStreamUrl(),
        'cover_page' => route('track.show', $t->slug),
    ])->values()->toArray();
    $apiUrl = route('browse.genre-tracks-json', $genre->slug) . '?' . http_build_query(request()->except('page'));
@endphp
<x-layouts.app :title="$genre->name_fa">
    <div class="p-4 lg:p-8 space-y-8">

        {{-- Genre Header --}}
        <div class="relative overflow-hidden rounded-3xl p-8 lg:p-12" style="background-color: {{ $genre->color ?? '#6366f1' }}">
            <div class="absolute inset-0 bg-gradient-to-l from-black/30 to-transparent"></div>
            <div class="relative z-10">
                <h1 class="text-3xl lg:text-5xl font-display font-extrabold text-white">{{ $genre->name_fa }}</h1>
                <p class="text-white/80 mt-2">{{ $genre->name }}</p>
            </div>
        </div>

        {{-- Tracks with infinite scroll --}}
        <section
            x-data="{
                tracks: {{ Js::from($initialTracks) }},
                hasMore: {{ $tracks->hasMorePages() ? 'true' : 'false' }},
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
            <template x-if="tracks.length === 0 && !loading">
                <div class="text-center py-20 text-surface-400">
                    <p>آهنگی در این ژانر یافت نشد</p>
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
                                    x-on:click.stop="$store.player.play({id: track.id, title: track.title, artist: track.artist, cover: track.cover, url: track.url})"
                                    class="opacity-0 group-hover:opacity-100 transition w-11 h-11 rounded-full bg-primary-500 hover:bg-primary-400 flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white mr-[-2px]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 min-w-0">
                            <a :href="track.cover_page" class="block text-sm font-medium text-surface-900 dark:text-white truncate hover:text-primary-500 transition-colors" x-text="track.title"></a>
                            <p class="text-xs text-surface-500 truncate" x-text="track.artist"></p>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="loading" class="flex justify-center py-8">
                <svg class="w-8 h-8 animate-spin text-primary-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
            </div>

            <div x-ref="sentinel" class="h-4"></div>
        </section>
    </div>
</x-layouts.app>
