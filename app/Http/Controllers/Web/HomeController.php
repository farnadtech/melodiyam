<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Genre;
use App\Models\HomepageSection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $sections = HomepageSection::active()->get();

        $featuredTracks = Track::published()->featured()
            ->with(['artist', 'album'])
            ->take(10)
            ->get();

        $newReleases = Track::published()
            ->with(['artist', 'album'])
            ->orderByDesc('release_date')
            ->take(12)
            ->get();

        $trendingTracks = Track::published()
            ->with(['artist', 'album'])
            ->where('created_at', '>=', now()->subDays(30))
            ->orderByDesc('play_count')
            ->take(12)
            ->get();

        $featuredArtists = Artist::where('is_featured', true)
            ->where('verification_status', 'approved')
            ->take(8)
            ->get();

        $featuredPlaylists = Playlist::public()->featured()
            ->with('user')
            ->take(8)
            ->get();

        $genres = Genre::active()->ordered()->take(12)->get();

        $latestAlbums = Album::published()
            ->with('artist')
            ->orderByDesc('release_date')
            ->take(8)
            ->get();

        return view('home', compact(
            'sections', 'featuredTracks', 'newReleases', 'trendingTracks',
            'featuredArtists', 'featuredPlaylists', 'genres', 'latestAlbums'
        ));
    }
}
