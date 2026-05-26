@php
    $cfg = $section->config ?? [];
    $limit = (int)($cfg['limit'] ?? 6);
    $cols  = (int)($cfg['columns'] ?? 6);
    $featuredOnly = (bool)($cfg['featured_only'] ?? true);

    $query = \App\Models\Playlist::public()->with('user');
    if ($featuredOnly) $query->featured();
    $playlists = $query->take($limit)->get();

    $colClass = match($cols) {
        2 => 'grid-cols-2',
        3 => 'grid-cols-2 sm:grid-cols-3',
        4 => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4',
        default => 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6',
    };
@endphp

@if($playlists->isNotEmpty())
<section>
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl lg:text-2xl font-bold font-display text-surface-900 dark:text-white">
            {{ $section->title_fa }}
        </h2>
    </div>
    <div class="grid {{ $colClass }} gap-4">
        @foreach($playlists as $playlist)
            @include('components.playlist-card', ['playlist' => $playlist])
        @endforeach
    </div>
</section>
@endif
