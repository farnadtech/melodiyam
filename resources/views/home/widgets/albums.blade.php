@php
    $cfg = $section->config;
    $limit  = (int)($cfg['limit']);
    $cols   = (int)($cfg['columns']);
    $sortBy = $cfg['sort_by'] ?? 'release_date';
    $showSeeAll = (bool)($cfg['show_see_all'] ?? true);
    $seeAllUrl  = !empty($cfg['see_all_url']) ? $cfg['see_all_url'] : route('albums.index', ['sort' => $sortBy]);
    $seeAllLabel = $cfg['see_all_label'] ?? 'مشاهده همه';

    $albums = \App\Models\Album::published()
        ->with('artist')
        ->sort($sortBy)
        ->take($limit)->get();

    $colClass = match($cols) {
        2 => 'grid-cols-2',
        3 => 'grid-cols-2 sm:grid-cols-3',
        4 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4',
        5 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5',
        default => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6',
    };
@endphp

@if($albums->isNotEmpty())
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
    <div class="grid {{ $colClass }} gap-4">
        @foreach($albums as $album)
            @include('components.album-card', ['album' => $album])
        @endforeach
    </div>
</section>
@endif
