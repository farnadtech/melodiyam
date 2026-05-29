@php
    $cfg = $section->config;
    $limit = (int)($cfg['limit']);
    $cols  = (int)($cfg['columns']);
    $showCount = (bool)($cfg['show_count']);

    $genres = \App\Models\Genre::active()->ordered()
        ->when($showCount, fn($q) => $q->withCount('tracks'))
        ->take($limit)->get();

    $colClass = match($cols) {
        3 => 'grid-cols-2 sm:grid-cols-3',
        4 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4',
        default => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6',
    };
@endphp

@if($genres->isNotEmpty())
<section>
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">
            {{ $section->title_fa }}
        </h2>
    </div>
    <div class="grid {{ $colClass }} gap-3">
        @foreach($genres as $genre)
            @include('components.genre-card', ['genre' => $genre, 'showCount' => $showCount])
        @endforeach
    </div>
</section>
@endif
