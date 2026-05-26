@php
    $cfg = $section->config ?? [];
    $limit = (int)($cfg['limit'] ?? 8);
    $cols  = (int)($cfg['columns'] ?? 8);
    $featuredOnly = (bool)($cfg['featured_only'] ?? true);

    $query = \App\Models\Artist::where('verification_status','approved');
    if ($featuredOnly) $query->where('is_featured', true);
    $artists = $query->take($limit)->get();

    $colClass = match($cols) {
        3 => 'grid-cols-3',
        4 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4',
        5 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5',
        6 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6',
        default => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8',
    };
@endphp

@if($artists->isNotEmpty())
<section>
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">
            {{ $section->title_fa }}
        </h2>
    </div>
    <div class="grid {{ $colClass }} gap-4">
        @foreach($artists as $artist)
            @include('components.artist-card', ['artist' => $artist])
        @endforeach
    </div>
</section>
@endif
