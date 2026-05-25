<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function index(): View
    {
        return view('library.index');
    }

    public function liked(): View
    {
        $tracks = auth()->user()->likes()
            ->where('likeable_type', \App\Models\Track::class)
            ->with('likeable.artist')
            ->latest()
            ->paginate(50);

        return view('library.liked', compact('tracks'));
    }

    public function playlists(): View
    {
        $myPlaylists = auth()->user()->playlists()
            ->withCount('tracks')
            ->latest()
            ->get();

        $savedPlaylists = auth()->user()->likes()
            ->where('likeable_type', \App\Models\Playlist::class)
            ->with('likeable.user')
            ->latest()
            ->get()
            ->pluck('likeable')
            ->filter();

        return view('library.playlists', compact('myPlaylists', 'savedPlaylists'));
    }

    public function history(): View
    {
        $history = auth()->user()->recentlyPlayed()
            ->with('playable')
            ->take(50)
            ->get();

        return view('library.history', compact('history'));
    }

    public function albums(): View
    {
        $albums = auth()->user()->likes()
            ->where('likeable_type', \App\Models\Album::class)
            ->with('likeable.artist')
            ->latest()
            ->get()
            ->pluck('likeable')
            ->filter();

        return view('library.albums', compact('albums'));
    }

    public function artists(): View
    {
        $artists = auth()->user()->follows()
            ->where('followable_type', \App\Models\Artist::class)
            ->with('followable')
            ->latest()
            ->get()
            ->pluck('followable')
            ->filter();

        return view('library.artists', compact('artists'));
    }

    public function downloads(): View
    {
        return view('library.downloads');
    }

    public function queue(): View
    {
        return view('library.queue');
    }

    public function wallet(): View
    {
        return view('library.wallet');
    }

    public function discover(): View
    {
        $newReleases = \App\Models\Track::with('artist')
            ->latest()
            ->take(20)
            ->get();

        $topArtists = \App\Models\Artist::orderByDesc('followers_count')
            ->take(12)
            ->get();

        return view('discover', compact('newReleases', 'topArtists'));
    }

    public function profile(): View
    {
        return view('library.profile');
    }

    public function settings(): View
    {
        return view('library.settings');
    }
}
