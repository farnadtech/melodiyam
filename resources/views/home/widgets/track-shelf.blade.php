@php
    $cfg     = $section->config ?? [];
    $limit   = (int)($cfg['limit']   ?? 6);
    $cols    = (int)($cfg['columns'] ?? 6);
    $layout  = $cfg['layout']        ?? 'grid';
    $sortBy  = $cfg['sort_by']       ?? 'release_date';
    $genreSlugs = array_filter((array)($cfg['genre_filter'] ?? []));
    $showSeeAll = (bool)($cfg['show_see_all'] ?? true);
    $seeAllLabel = $cfg['see_all_label'] ?? 'مشاهده همه';

    // Auto-build see_all_url based on type + genre filters + sort
    if (!empty($cfg['see_all_url'])) {
        $seeAllUrl = $cfg['see_all_url'];
    } else {
        // Map widget sort_by → browse URL sort param
        $sortMap = [
            'release_date' => 'release_date',
            'created_at'   => 'created_at',
            'play_count'   => 'play_count',
            'like_count'   => 'play_count', // browse page doesn't have like sort, fallback to play_count
        ];
        $sortParam = $sortMap[$sortBy] ?? 'play_count';

        $params = [];
        if (!empty($genreSlugs)) {
            $params['genre'] = array_values($genreSlugs);
        }
        // Always include sort so browse page respects the same ordering
        $params['sort'] = $sortParam;

        if (count($genreSlugs) === 1 && $sortParam === 'play_count') {
            // single genre + default sort → dedicated clean genre page
            $seeAllUrl = route('browse.genre', reset($genreSlugs));
        } else {
            $seeAllUrl = route('browse') . '?' . http_build_query($params);
        }
    }

    $type = $section->type;

    $buildQuery = function(bool $withGenre) use ($genreSlugs, $sortBy, $limit, $type) {
        $q = \App\Models\Track::published()->with(['artist','album']);
        if ($withGenre && !empty($genreSlugs)) {
            $genreIds = \App\Models\Genre::whereIn('slug', $genreSlugs)->pluck('id');
            $q->where(function($wq) use ($genreIds, $genreSlugs) {
                $wq->whereIn('genre_id', $genreIds)
                   ->orWhereHas('genres', fn($gq) => $gq->whereIn('slug', $genreSlugs));
            });
        }
        if ($type === 'trending') {
            $q->where('created_at', '>=', now()->subDays(30));
        }
        $q->orderByDesc($sortBy === 'like_count' ? 'play_count' : $sortBy);
        return $q->take($limit)->get();
    };

    $tracks = $buildQuery(true);
    if ($tracks->isEmpty() && !empty($genreSlugs)) {
        $tracks = $buildQuery(false);
    }

    $colClass = match($cols) {
        2 => 'grid-cols-2',
        3 => 'grid-cols-2 sm:grid-cols-3',
        4 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4',
        5 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5',
        default => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6',
    };
@endphp

@if($tracks->isNotEmpty())
<section>
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">
                {{ $section->title_fa }}
            </h2>
        </div>
        @if($showSeeAll)
        <a href="{{ $seeAllUrl }}" wire:navigate class="btn-ghost text-sm">{{ $seeAllLabel }}</a>
        @endif
    </div>

    @if($layout === 'scroll')
    <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-2 cursor-grab" x-drag-scroll>
        @foreach($tracks as $track)
            <div class="flex-shrink-0 w-40">
                @include('components.track-card', ['track' => $track])
            </div>
        @endforeach
    </div>
    @elseif($layout === 'list')
    <div class="space-y-2">
        @foreach($tracks as $i => $track)
        <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-800 transition cursor-pointer group"
             x-on:click="$store.player.play({{ json_encode(['id'=>$track->id,'title'=>$track->title,'artist'=>$track->artist?->name,'cover'=>$track->cover_url,'url'=>$track->stream_url,'cover_page'=>route('track.show',$track->slug ?? $track->id),'artist_url'=>$track->artist?->slug ? route('artist.show',$track->artist->slug) : '']) }})">
            <span class="text-surface-400 text-sm w-6 text-center font-mono">{{ $i + 1 }}</span>
            <img src="{{ $track->cover_url ?? asset('images/default-cover.png') }}" class="w-10 h-10 rounded-lg object-cover" alt="">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-surface-900 dark:text-white truncate">{{ $track->title }}</p>
                <p class="text-xs text-surface-500 truncate">{{ $track->artist?->name }}</p>
            </div>
            <span class="text-xs text-surface-400">{{ gmdate('i:s', $track->duration ?? 0) }}</span>
        </div>
        @endforeach
    </div>
    @else
    <div class="grid {{ $colClass }} gap-4">
        @foreach($tracks as $track)
            @include('components.track-card', ['track' => $track])
        @endforeach
    </div>
    @endif
</section>
@endif
