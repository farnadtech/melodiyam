@php
    $widgetMap = [
        'hero'               => 'home.widgets.hero',
        'new_releases'       => 'home.widgets.track-shelf',
        'trending'           => 'home.widgets.track-shelf',
        'top_charts'         => 'home.widgets.top-charts',
        'featured_artists'   => 'home.widgets.artists',
        'featured_playlists' => 'home.widgets.playlists',
        'genres'             => 'home.widgets.genres',
        'latest_albums'      => 'home.widgets.albums',
        'artist_spotlight'   => 'home.widgets.artist-spotlight',
        'banner'             => 'home.widgets.banner',
        'custom_tracks'      => 'home.widgets.custom-tracks',
        'featured_track'     => 'home.widgets.featured-track',
    ];

    $view = $widgetMap[$section->type] ?? null;
@endphp

@if($view && view()->exists($view))
    @include($view, ['section' => $section])
@endif
