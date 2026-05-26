@php
    $cfg        = $section->config ?? [];
    $limit      = (int)($cfg['limit']  ?? 10);
    $period     = (int)($cfg['period'] ?? 30);
    $layout     = $cfg['layout']   ?? 'list';
    $cols       = (int)($cfg['columns'] ?? 4);
    $genreSlugs = array_filter((array)($cfg['genre_filter'] ?? []));

    $buildQuery = function(bool $withGenre) use ($genreSlugs, $period, $limit) {
        $q = \App\Models\Track::published()->with(['artist','album'])
            ->where('created_at', '>=', now()->subDays($period))
            ->orderByDesc('play_count');
        if ($withGenre && !empty($genreSlugs)) {
            $genreIds = \App\Models\Genre::whereIn('slug', $genreSlugs)->pluck('id');
            $q->where(function($wq) use ($genreIds, $genreSlugs) {
                $wq->whereIn('genre_id', $genreIds)
                   ->orWhereHas('genres', fn($gq) => $gq->whereIn('slug', $genreSlugs));
            });
        }
        return $q->take($limit)->get();
    };

    $tracks = $buildQuery(true);
    if ($tracks->isEmpty() && !empty($genreSlugs)) {
        $tracks = $buildQuery(false);
    }

    $colClass = match($cols) {
        2 => 'grid-cols-2',
        3 => 'grid-cols-2 sm:grid-cols-3',
        5 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5',
        6 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6',
        default => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4',
    };
@endphp

@if($tracks->isNotEmpty())
<section>
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">
                {{ $section->title_fa }}
            </h2>
            <p class="text-sm text-surface-500 mt-1">پرپخش‌ترین آهنگ‌های {{ $period }} روز گذشته</p>
        </div>
    </div>

    {{-- LIST layout --}}
    @if($layout === 'list')
    <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 divide-y divide-surface-100 dark:divide-surface-800 overflow-hidden">
        @foreach($tracks as $i => $track)
        <div class="flex items-center gap-4 px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-800 transition cursor-pointer"
             x-on:click="$store.player.play({{ json_encode(['id'=>$track->id,'title'=>$track->title,'artist'=>$track->artist?->name,'cover'=>$track->cover_url,'url'=>$track->stream_url]) }})">
            <span class="font-mono w-7 text-center text-sm flex-shrink-0 {{ $i===0?'text-yellow-500 font-bold':($i===1?'text-surface-400 font-bold':($i===2?'text-orange-400 font-bold':'text-surface-400')) }}">
                {{ $i===0?'🥇':($i===1?'🥈':($i===2?'🥉':$i+1)) }}
            </span>
            <img src="{{ $track->cover_url ?? asset('images/default-cover.png') }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0" alt="">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-surface-900 dark:text-white truncate">{{ $track->title }}</p>
                <p class="text-xs text-surface-500 truncate">{{ $track->artist?->name }}</p>
            </div>
            <div class="text-xs text-surface-400 flex items-center gap-1 flex-shrink-0">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                {{ number_format($track->play_count ?? 0) }}
            </div>
        </div>
        @endforeach
    </div>

    {{-- GRID layout --}}
    @elseif($layout === 'grid')
    <div class="grid {{ $colClass }} gap-4">
        @foreach($tracks as $i => $track)
        <div class="relative cursor-pointer group"
             x-on:click="$store.player.play({{ json_encode(['id'=>$track->id,'title'=>$track->title,'artist'=>$track->artist?->name,'cover'=>$track->cover_url,'url'=>$track->stream_url]) }})">
            <span class="absolute top-2 right-2 z-10 w-7 h-7 rounded-full bg-black/60 text-white text-xs font-bold flex items-center justify-center">
                {{ $i===0?'🥇':($i===1?'🥈':($i===2?'🥉':$i+1)) }}
            </span>
            <img src="{{ $track->cover_url ?? asset('images/default-cover.png') }}"
                 class="w-full aspect-square object-cover rounded-xl group-hover:brightness-75 transition" alt="{{ $track->title }}">
            <div class="mt-2 px-1">
                <p class="text-sm font-medium text-surface-900 dark:text-white truncate">{{ $track->title }}</p>
                <p class="text-xs text-surface-500 truncate">{{ $track->artist?->name }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- SCROLL layout --}}
    @else
    <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-2 cursor-grab" x-drag-scroll>
        @foreach($tracks as $i => $track)
        <div class="flex-shrink-0 w-36 cursor-pointer group"
             x-on:click="$store.player.play({{ json_encode(['id'=>$track->id,'title'=>$track->title,'artist'=>$track->artist?->name,'cover'=>$track->cover_url,'url'=>$track->stream_url]) }})">
            <div class="relative">
                <span class="absolute top-2 right-2 z-10 w-6 h-6 rounded-full bg-black/60 text-white text-xs font-bold flex items-center justify-center">
                    {{ $i===0?'🥇':($i===1?'🥈':($i===2?'🥉':$i+1)) }}
                </span>
                <img src="{{ $track->cover_url ?? asset('images/default-cover.png') }}"
                     class="w-full aspect-square object-cover rounded-xl group-hover:brightness-75 transition" alt="">
            </div>
            <p class="text-xs font-medium text-surface-900 dark:text-white truncate mt-2">{{ $track->title }}</p>
            <p class="text-xs text-surface-500 truncate">{{ $track->artist?->name }}</p>
        </div>
        @endforeach
    </div>
    @endif

</section>
@endif
