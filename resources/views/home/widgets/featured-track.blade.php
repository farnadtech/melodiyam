@php
    $cfg        = $section->config ?? [];
    $sortBy     = $cfg['sort_by']  ?? 'play_count';
    $limit      = (int)($cfg['limit'] ?? 5);
    $genreSlugs = array_filter((array)($cfg['genre_filter'] ?? []));
    $autoplay   = (bool)($cfg['autoplay'] ?? true);
    $interval   = (int)($cfg['autoplay_interval'] ?? 5);
    $showPlay   = (bool)($cfg['show_play_btn'] ?? true);

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
        if ($sortBy === 'play_count') {
            $query->where('created_at', '>=', now()->subDays(90));
        }
        $query->orderByDesc($sortBy);
        $tracks = $query->take($limit)->get();
    }

    $tracksJson = $tracks->isEmpty() ? '[]' : $tracks->map(fn($t) => [
        'id'     => $t->id,
        'title'  => $t->title,
        'artist' => $t->artist?->name ?? '',
        'album'  => $t->album?->title ?? '',
        'cover'  => $t->cover_url ?? asset('images/default-cover.png'),
        'url'    => $t->stream_url ?? '',
        'duration' => gmdate('i:s', $t->duration ?? 0),
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
    <div class="relative overflow-hidden rounded-3xl" style="min-height: 320px;">

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
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6 p-6 lg:p-10">

            {{-- Cover with slide animation --}}
            <div class="relative w-48 h-48 flex-shrink-0">
                <template x-for="(track, i) in tracks" :key="'cover-'+i">
                    <div
                        class="absolute inset-0 transition-all duration-350 ease-in-out"
                        :class="{
                            'opacity-100 translate-x-0 scale-100': i === current,
                            'opacity-0 translate-x-8 scale-95 pointer-events-none': i !== current && direction === 'next',
                            'opacity-0 -translate-x-8 scale-95 pointer-events-none': i !== current && direction === 'prev'
                        }"
                    >
                        <img :src="track.cover"
                             class="w-full h-full object-cover rounded-2xl shadow-2xl ring-4 ring-white/20"
                             :alt="track.title">
                    </div>
                </template>
            </div>

            {{-- Info with slide animation --}}
            <div class="flex-1 text-white text-center md:text-right min-w-0 relative overflow-hidden" style="min-height: 140px;">
                <template x-for="(track, i) in tracks" :key="'info-'+i">
                    <div
                        class="absolute inset-0 flex flex-col justify-center transition-all duration-350 ease-in-out"
                        :class="{
                            'opacity-100 translate-y-0': i === current,
                            'opacity-0 translate-y-4 pointer-events-none': i !== current && direction === 'next',
                            'opacity-0 -translate-y-4 pointer-events-none': i !== current && direction === 'prev'
                        }"
                    >
                        <p class="text-white/60 text-sm font-medium mb-1" x-text="track.artist"></p>
                        <h3 class="text-2xl lg:text-3xl font-display font-extrabold leading-tight mb-2 drop-shadow-lg" x-text="track.title"></h3>
                        <p class="text-white/50 text-sm mb-5" x-text="track.album ? '💿 ' + track.album : ''"></p>

                        @if($showPlay)
                        <div class="flex items-center gap-3 justify-center md:justify-start">
                            <button
                                @click="$store.player.play(track)"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-surface-900 font-bold text-sm hover:bg-white/90 active:scale-95 transition-all shadow-lg"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                پخش
                            </button>
                            <span class="text-white/40 text-sm font-mono" x-text="track.duration"></span>
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
