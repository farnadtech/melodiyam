<x-layouts.app title="جستجو">
    <div class="p-4 lg:p-8 space-y-12" 
         x-data="{ 
            q: '{{ request('q', '') }}',
            results: null,
            loading: false,
            async performSearch() {
                if (this.q.length < 2) {
                    this.results = null;
                    return;
                }
                this.loading = true;
                try {
                    const resp = await fetch('/api/v1/search?q=' + encodeURIComponent(this.q));
                    this.results = await resp.json();
                    console.log('Search results:', this.results);
                } catch (e) {
                    console.error('Search error:', e);
                } finally {
                    this.loading = false;
                }
            }
         }"
         x-init="
            if(q.length >= 2) performSearch();
            $watch('q', (v) => { 
                if(!v || v.length < 2) { results = null; return; }
                performSearch();
            });
         "
    >

        {{-- Centered Header & Search Bar --}}
        <div class="flex flex-col items-center justify-center text-center space-y-8 py-6">
            <h1 class="text-3xl lg:text-5xl font-display font-black text-surface-900 dark:text-white tracking-tight">جستجو</h1>
            
            <div class="relative w-full max-w-3xl group">
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                    <svg x-show="!loading" class="w-6 h-6 text-surface-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <svg x-show="loading" class="w-6 h-6 text-primary-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    x-model.debounce.400ms="q"
                    placeholder="نام آهنگ، هنرمند، آلبوم یا پادکست..." 
                    class="w-full h-16 pr-14 pl-6 text-lg bg-white dark:bg-surface-800 rounded-2xl border-2 border-surface-100 dark:border-surface-700 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-4 focus:ring-primary-500/10 transition-all shadow-lg dark:shadow-2xl outline-none text-surface-900 dark:text-white" 
                    autofocus
                >
            </div>
        </div>

        {{-- Results Area --}}
        <div x-cloak class="min-h-[400px]">
            {{-- Empty State (No query) --}}
            <div x-show="q.length < 2 && !results" class="flex flex-col items-center justify-center py-20 text-center animate-in fade-in duration-700">
                <div class="w-24 h-24 bg-surface-100 dark:bg-surface-800 rounded-3xl flex items-center justify-center mb-6 text-surface-300 dark:text-surface-600 rotate-12">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-surface-900 dark:text-white mb-2">آماده جستجو هستیم!</h3>
                <p class="text-surface-500">چیزی تایپ کنید تا جادوی ملودیام رو ببینید...</p>
            </div>

            {{-- Live Results --}}
            <div x-show="results" class="space-y-16 animate-in fade-in slide-in-from-bottom-4 duration-500">
                
                {{-- Tracks --}}
                <template x-if="results && results.tracks && results.tracks.length > 0">
                    <section>
                        <div class="flex items-center gap-3 mb-8">
                            <span class="w-2 h-8 bg-primary-500 rounded-full"></span>
                            <h2 class="text-2xl font-black text-surface-900 dark:text-white">آهنگ‌ها</h2>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6 md:gap-8">
                            <template x-for="track in results.tracks" :key="track.id">
                                <div class="group relative flex flex-col">
                                    <div class="relative aspect-square overflow-hidden rounded-2xl mb-4 shadow-lg group-hover:shadow-primary-500/20 transition-all duration-300">
                                        <img :src="track.cover_url" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <button @click="$store.player.play(track)" class="w-14 h-14 bg-primary-500 rounded-full flex items-center justify-center text-white shadow-2xl transform scale-75 group-hover:scale-100 transition-all duration-300 hover:bg-primary-400">
                                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <h3 class="font-bold text-surface-900 dark:text-white truncate mb-1 text-base group-hover:text-primary-500 transition-colors" x-text="track.title"></h3>
                                    <p class="text-surface-500 dark:text-surface-400 text-sm truncate font-medium" x-text="track.artist ? track.artist.display_name : 'هنرمند ناشناس'"></p>
                                    <a :href="'/track/' + track.slug" class="absolute inset-0 z-0" @click.prevent="Livewire.navigate('/track/' + track.slug)"></a>
                                </div>
                            </template>
                        </div>
                    </section>
                </template>

                {{-- Artists --}}
                <template x-if="results && results.artists && results.artists.length > 0">
                    <section>
                        <div class="flex items-center gap-3 mb-8">
                            <span class="w-2 h-8 bg-secondary-500 rounded-full"></span>
                            <h2 class="text-2xl font-black text-surface-900 dark:text-white">هنرمندان</h2>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-8">
                            <template x-for="artist in results.artists" :key="artist.id">
                                <a :href="'/artist/' + artist.slug" @click.prevent="Livewire.navigate('/artist/' + artist.slug)" class="group flex flex-col items-center text-center">
                                    <div class="relative w-full aspect-square mb-4 rounded-full overflow-hidden ring-4 ring-transparent group-hover:ring-secondary-500 transition-all duration-300 shadow-lg">
                                        <img :src="artist.avatar ? '/storage/' + artist.avatar : '/images/default-artist.png'" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    </div>
                                    <h3 class="font-bold text-surface-900 dark:text-white truncate text-sm group-hover:text-secondary-500 transition-colors" x-text="artist.display_name"></h3>
                                </a>
                            </template>
                        </div>
                    </section>
                </template>

                {{-- Albums --}}
                <template x-if="results && results.albums && results.albums.length > 0">
                    <section>
                        <div class="flex items-center gap-3 mb-8">
                            <span class="w-2 h-8 bg-amber-500 rounded-full"></span>
                            <h2 class="text-2xl font-black text-surface-900 dark:text-white">آلبوم‌ها</h2>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            <template x-for="album in results.albums" :key="album.id">
                                <a :href="'/album/' + album.slug" @click.prevent="Livewire.navigate('/album/' + album.slug)" class="group relative bg-surface-50 dark:bg-surface-800/40 p-3 rounded-2xl transition-all hover:bg-white dark:hover:bg-surface-800 border border-transparent hover:border-surface-100 dark:hover:border-surface-700">
                                    <div class="relative aspect-square overflow-hidden rounded-xl mb-4 shadow-md">
                                        <img :src="album.cover_url" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    <h3 class="font-bold text-surface-900 dark:text-white truncate text-sm" x-text="album.title"></h3>
                                    <p class="text-surface-500 text-xs mt-1 truncate" x-text="album.artist ? album.artist.display_name : ''"></p>
                                </a>
                            </template>
                        </div>
                    </section>
                </template>

                {{-- Podcasts --}}
                <template x-if="results && results.podcasts && results.podcasts.length > 0">
                    <section>
                        <div class="flex items-center gap-3 mb-8">
                            <span class="w-2 h-8 bg-purple-500 rounded-full"></span>
                            <h2 class="text-2xl font-black text-surface-900 dark:text-white">پادکست‌ها</h2>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            <template x-for="podcast in results.podcasts" :key="podcast.id">
                                <a :href="'/podcast/' + podcast.slug" @click.prevent="Livewire.navigate('/podcast/' + podcast.slug)" class="group relative bg-surface-50 dark:bg-surface-800/40 p-3 rounded-2xl transition-all hover:bg-white dark:hover:bg-surface-800 border border-transparent hover:border-surface-100 dark:hover:border-surface-700">
                                    <div class="relative aspect-square overflow-hidden rounded-xl mb-4 shadow-md">
                                        <img :src="podcast.cover_url" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    <h3 class="font-bold text-surface-900 dark:text-white truncate text-sm" x-text="podcast.title"></h3>
                                    <p class="text-surface-500 text-xs mt-1 truncate" x-text="podcast.artist ? podcast.artist.display_name : ''"></p>
                                </a>
                            </template>
                        </div>
                    </section>
                </template>

                {{-- Empty Results (Query exists but no results found) --}}
                <div x-show="results && [results.tracks, results.artists, results.albums, results.podcasts].every(a => !a || a.length === 0)" class="flex flex-col items-center justify-center py-20 text-center animate-in zoom-in-95 duration-500">
                    <div class="text-6xl mb-6">🔍</div>
                    <h3 class="text-xl font-bold text-surface-900 dark:text-white mb-2">نتیجه‌ای پیدا نکردیم</h3>
                    <p class="text-surface-500">متاسفانه برای «<span x-text="q" class="text-primary-500 font-bold"></span>» چیزی پیدا نشد. کلمات دیگه‌ای رو امتحان کن.</p>
                </div>

            </div>
        </div>

    </div>
</x-layouts.app>
