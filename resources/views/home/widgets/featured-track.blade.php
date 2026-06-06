@php
    $cfg        = $section->config;
    $sortBy     = $cfg['sort_by'];
    $limit      = (int)($cfg['limit']);
    $genreSlugs = array_filter((array)($cfg['genre_filter'] ?? []));
    $autoplay   = (bool)($cfg['autoplay']);
    $interval   = (int)($cfg['autoplay_interval']);
    $showPlay   = (bool)($cfg['show_play_btn']);

    if ($sortBy === 'manual') {
        $manualIds = collect($cfg['manual_track_ids'] ?? [])->pluck('id')->filter()->values();
        $tracks = $manualIds->isNotEmpty()
            ? \App\Models\Track::published()->with(['artist','album'])
                ->whereIn('id', $manualIds)
                ->orderByRaw('FIELD(id,' . $manualIds->implode(',') . ')')
                ->get()
            : collect();
    } else {
        $query = \App\Models\Track::published()->with(['artist','album']);
        if (!empty($genreSlugs)) {
            $query->whereHas('genres', fn($q) => $q->whereIn('slug', $genreSlugs));
        }
        $query->sort($sortBy);
        $tracks = $query->take($limit)->get();
    }

    $tracksJson = $tracks->isEmpty() ? '[]' : $tracks->map(fn($t) => [
        'id'     => $t->id,
        'title'  => $t->title,
        'artist' => $t->artist?->display_name ?? $t->artist?->name ?? '',
        'album'  => $t->album?->title ?? '',
        'cover'  => $t->getCoverUrl(),
        'url'    => $t->getStreamUrl(),
        'duration' => $t->formatted_duration,
        'cover_page' => route('track.show', $t->slug),
        'artist_url' => $t->artist ? route('artist.show', $t->artist->slug) : null,
    ])->values()->toJson();
@endphp

@if($tracks->isNotEmpty())
<section
    x-data="{
        tracks: {{ $tracksJson }},
        current: 0,
        direction: 'next',
        animating: false,
        autoplay: {{ $autoplay ? 'true' : 'false' }},
        interval: {{ $interval * 1000 }},
        timer: null,
        get track() { return this.tracks[this.current]; },
        go(index) {
            if (this.animating || index === this.current) return;
            this.direction = index > this.current ? 'next' : 'prev';
            this.animating = true;
            setTimeout(() => {
                this.current = index;
                this.animating = false;
            }, 350);
        },
        next() { this.go((this.current + 1) % this.tracks.length); },
        prev() { this.go((this.current - 1 + this.tracks.length) % this.tracks.length); },
        startAutoplay() {
            if (!this.autoplay) return;
            this.timer = setInterval(() => this.next(), this.interval);
        },
        stopAutoplay() { clearInterval(this.timer); }
    }"
    x-init="startAutoplay()"
    @mouseenter="stopAutoplay()"
    @mouseleave="startAutoplay()"
>
    <div class="relative overflow-hidden rounded-3xl min-h-[500px] md:min-h-[350px]">

        {{-- Background blur cover --}}
        <template x-for="(track, i) in tracks" :key="i">
            <div
                class="absolute inset-0 transition-opacity duration-700"
                :class="i === current ? 'opacity-100' : 'opacity-0'"
            >
                <img :src="track.cover" class="w-full h-full object-cover scale-110 blur-2xl" alt="" aria-hidden="true">
                <div class="absolute inset-0 bg-black/60"></div>
            </div>
        </template>

        {{-- Main card content --}}
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-center gap-8 p-8 md:p-10 h-full">

            {{-- Cover with slide animation --}}
            <div class="relative w-56 h-56 md:w-64 md:h-64 flex-shrink-0">
                <template x-for="(track, i) in tracks" :key="'cover-'+i">
                    <div
                        class="absolute inset-0 transition-all duration-350 ease-in-out"
                        :class="{
                            'opacity-100 translate-x-0 scale-100': i === current,
                            'opacity-0 translate-x-8 scale-95 pointer-events-none': i !== current && direction === 'next',
                            'opacity-0 -translate-x-8 scale-95 pointer-events-none': i !== current && direction === 'prev'
                        }"
                    >
                        <div class="relative w-full h-full overflow-hidden rounded-2xl shadow-2xl ring-4 ring-white/20 bg-surface-100 dark:bg-surface-800 cursor-pointer" @click="Livewire.navigate(track.cover_page)">
                            <img :src="track.cover" alt="" class="absolute inset-0 w-full h-full object-cover blur-xl opacity-50 scale-110">
                            <img :src="track.cover" class="relative z-10 w-full h-full object-contain" :alt="track.title">
                        </div>
                    </div>
                </template>
            </div>

            {{-- Info Section (Refactored to Grid for better mobile visibility) --}}
            <div class="flex-1 w-full md:w-auto grid grid-cols-1 grid-rows-1">
                <template x-for="(track, i) in tracks" :key="'info-'+i">
                    <div
                        class="col-start-1 row-start-1 flex flex-col justify-center text-white text-center md:text-right transition-all duration-350 ease-in-out"
                        :class="{
                            'opacity-100 translate-y-0 relative z-10': i === current,
                            'opacity-0 translate-y-4 pointer-events-none absolute inset-0': i !== current && direction === 'next',
                            'opacity-0 -translate-y-4 pointer-events-none absolute inset-0': i !== current && direction === 'prev'
                        }"
                    >
                        <p class="text-white/60 text-sm font-medium mb-1 truncate cursor-pointer hover:text-white transition-colors" @click="if(track.artist_url) Livewire.navigate(track.artist_url)" x-text="track.artist"></p>
                        <h3 class="text-3xl md:text-4xl lg:text-5xl font-display font-extrabold leading-tight mb-2 drop-shadow-lg truncate cursor-pointer hover:text-primary-400 transition-colors" @click="Livewire.navigate(track.cover_page)" x-text="track.title"></h3>
                        <p class="text-white/50 text-sm mb-6 truncate" x-text="track.album ? '💿 ' + track.album : ''"></p>

                        @if($showPlay)
                        <div class="flex items-center gap-4 justify-center md:justify-start">
                            <button
                                @click="$store.player.play(track)"
                                class="inline-flex items-center gap-3 px-10 py-4 rounded-2xl bg-white text-surface-900 font-bold text-base hover:bg-primary-500 hover:text-white active:scale-95 transition-all shadow-xl"
                            >
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                پخش آهنگ
                            </button>
                            <span class="text-white/40 text-sm font-mono bg-white/10 px-3 py-1 rounded-lg" x-text="track.duration"></span>
                        </div>
                        @endif
                    </div>
                </template>
            </div>
        </div>

        {{-- Prev / Next arrows --}}
        <button @click="prev()"
            class="absolute top-1/2 right-4 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-sm flex items-center justify-center text-white transition-all active:scale-90">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
        <button @click="next()"
            class="absolute top-1/2 left-4 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-sm flex items-center justify-center text-white transition-all active:scale-90">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
            <template x-for="(track, i) in tracks" :key="'dot-'+i">
                <button
                    @click="go(i)"
                    class="rounded-full transition-all duration-300"
                    :class="i === current
                        ? 'w-6 h-2 bg-white'
                        : 'w-2 h-2 bg-white/40 hover:bg-white/70'"
                ></button>
            </template>
        </div>

    </div>

    {{-- Section title --}}
    <div class="mt-3 flex items-center justify-between px-1">
        <p class="text-sm font-medium text-surface-500">{{ $section->title_fa }}</p>
        <p class="text-xs text-surface-400">
            <span x-text="current + 1"></span> / {{ $tracks->count() }}
        </p>
    </div>
</section>
@endif
