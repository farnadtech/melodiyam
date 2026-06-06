<x-layouts.app title="جستجو">
    <div class="p-4 lg:p-8 space-y-8" 
         x-data="{ 
            q: '{{ $query ?? '' }}',
            results: null,
            loading: false,
            async performSearch() {
                if (this.q.length < 2) {
                    this.results = null;
                    return;
                }
                this.loading = true;
                try {
                    const resp = await fetch('/api/search?q=' + encodeURIComponent(this.q));
                    this.results = await resp.json();
                } catch (e) {
                    console.error(e);
                }
                this.loading = false;
            }
         }"
         x-init="$watch('q', (v) => { 
            if(!v) { results = null; return; }
            performSearch();
         })"
    >

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h1 class="text-2xl lg:text-3xl font-display font-bold text-surface-900 dark:text-white text-nowrap">جستجو</h1>
            
            {{-- Search box (Always visible and Live) --}}
            <div class="relative flex-1 max-w-2xl">
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-surface-400" :class="loading ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <template x-if="!loading">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </template>
                    <template x-if="loading">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </template>
                </svg>
                <input 
                    type="text" 
                    x-model.debounce.300ms="q"
                    placeholder="آهنگ، هنرمند، آلبوم، پادکست..." 
                    class="input-field pr-11 w-full bg-surface-100 dark:bg-surface-800 border-none focus:ring-2 focus:ring-primary-500" 
                    autofocus
                >
            </div>
        </div>

        {{-- Initial/Server-side results (hidden if Live Search starts) --}}
        <div x-show="!results && q.length < 2" class="space-y-8">
            @if(empty($query))
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-surface-100 dark:bg-surface-800 rounded-full flex items-center justify-center mx-auto mb-6 text-surface-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <p class="text-surface-500 text-lg">عبارتی برای جستجو وارد کنید</p>
                </div>
            @endif
        </div>

        {{-- Live Results Template --}}
        <div x-show="results || (q.length >= 2)" class="space-y-12">
            
            {{-- Tracks --}}
            <template x-if="results && results.tracks && results.tracks.length > 0">
                <section>
                    <h2 class="text-xl font-bold text-surface-900 dark:text-white mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-primary-500 rounded-full"></span>
                        آهنگ‌ها
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                        <template x-for="track in results.tracks" :key="track.id">
                            <div class="group relative bg-surface-50 dark:bg-surface-800/40 p-3 rounded-2xl transition-all hover:bg-white dark:hover:bg-surface-800 hover:shadow-xl border border-transparent hover:border-surface-100 dark:hover:border-surface-700">
                                <div class="relative aspect-square overflow-hidden rounded-xl mb-4">
                                    <img :src="track.cover_url" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <button @click="$store.player.play(track)" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center text-white shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </button>
                                </div>
                                <h3 class="font-bold text-surface-900 dark:text-white truncate text-sm" x-text="track.title"></h3>
                                <p class="text-surface-500 text-xs mt-1 truncate" x-text="track.artist ? track.artist.display_name : 'کاربر'"></p>
                                <a :href="'/track/' + track.slug" class="absolute inset-0" @click.prevent="Livewire.navigate('/track/' + track.slug)"></a>
                            </div>
                        </template>
                    </div>
                </section>
            </template>

            {{-- Artists --}}
            <template x-if="results && results.artists && results.artists.length > 0">
                <section>
                    <h2 class="text-xl font-bold text-surface-900 dark:text-white mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-primary-500 rounded-full"></span>
                        هنرمندان
                    </h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-6">
                        <template x-for="artist in results.artists" :key="artist.id">
                            <a :href="'/artist/' + artist.slug" @click.prevent="Livewire.navigate('/artist/' + artist.slug)" class="group text-center">
                                <div class="relative w-full aspect-square mb-4">
                                    <img :src="artist.avatar ? '/storage/' + artist.avatar : '/images/default-artist.png'" class="w-full h-full object-cover rounded-full ring-4 ring-transparent group-hover:ring-primary-500 transition-all">
                                </div>
                                <h3 class="font-bold text-surface-900 dark:text-white truncate text-sm" x-text="artist.display_name"></h3>
                            </a>
                        </template>
                    </div>
                </section>
            </template>

            {{-- Empty State --}}
            <template x-if="results && [results.tracks, results.artists, results.albums, results.podcasts].every(a => !a || a.length === 0)">
                <div class="text-center py-16">
                    <p class="text-surface-500 text-lg">نتیجه‌ای برای «<span x-text="q"></span>» یافت نشد</p>
                </div>
            </template>

        </div>

    </div>
</x-layouts.app>
