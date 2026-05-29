@php
    $cfg     = $section->config;
    $layout  = $cfg['layout'];
    $cols    = (int)($cfg['columns']);
    $showSeeAll = (bool)($cfg['show_see_all']);

    $trackIds    = collect($cfg['track_ids']    ?? [])->pluck('id')->filter()->values();
    $albumIds    = collect($cfg['album_ids']    ?? [])->pluck('id')->filter()->values();
    $playlistIds = collect($cfg['playlist_ids'] ?? [])->pluck('id')->filter()->values();

    $tracks    = $trackIds->isNotEmpty()
        ? \App\Models\Track::published()->with(['artist','album'])->whereIn('id', $trackIds)
            ->orderByRaw('FIELD(id,' . $trackIds->implode(',') . ')')->get()
        : collect();

    $albums    = $albumIds->isNotEmpty()
        ? \App\Models\Album::published()->with('artist')->whereIn('id', $albumIds)
            ->orderByRaw('FIELD(id,' . $albumIds->implode(',') . ')')->get()
        : collect();

    $playlists = $playlistIds->isNotEmpty()
        ? \App\Models\Playlist::public()->with('user')->whereIn('id', $playlistIds)
            ->orderByRaw('FIELD(id,' . $playlistIds->implode(',') . ')')->get()
        : collect();

    $colClass = match($cols) {
        2 => 'grid-cols-2',
        3 => 'grid-cols-2 sm:grid-cols-3',
        4 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4',
        5 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5',
        default => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6',
    };

    $hasContent = $tracks->isNotEmpty() || $albums->isNotEmpty() || $playlists->isNotEmpty();
@endphp

@if($hasContent)
<section>
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">
            {{ $section->title_fa }}
        </h2>
    </div>

    @if($tracks->isNotEmpty())
        @if($layout === 'scroll')
        <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-2 mb-6 cursor-grab" x-drag-scroll>
            @foreach($tracks as $track)
                <div class="flex-shrink-0 w-40">@include('components.track-card', ['track' => $track])</div>
            @endforeach
        </div>
        @elseif($layout === 'list')
        <div class="space-y-2 mb-6">
            @foreach($tracks as $i => $track)
            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-800 transition cursor-pointer"
                 x-on:click="$store.player.play({{ json_encode(['id'=>$track->id,'title'=>$track->title,'artist'=>$track->artist?->name,'cover'=>$track->cover_url,'url'=>$track->stream_url]) }})">
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
        <div class="grid {{ $colClass }} gap-4 mb-6">
            @foreach($tracks as $track)
                @include('components.track-card', ['track' => $track])
            @endforeach
        </div>
        @endif
    @endif

    @if($albums->isNotEmpty())
        <div class="grid {{ $colClass }} gap-4 mb-6">
            @foreach($albums as $album)
                @include('components.album-card', ['album' => $album])
            @endforeach
        </div>
    @endif

    @if($playlists->isNotEmpty())
        <div class="grid {{ $colClass }} gap-4">
            @foreach($playlists as $playlist)
                @include('components.playlist-card', ['playlist' => $playlist])
            @endforeach
        </div>
    @endif
</section>
@endif
