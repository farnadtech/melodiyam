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

        $newAlbums = \App\Models\Album::with('artist')
            ->where('status', 'published')
            ->latest()
            ->take(12)
            ->get();

        return view('discover', compact('newReleases', 'topArtists', 'newAlbums'));
    }

    public function profile(): View
    {
        $user = auth()->user();
        $likeCount     = \App\Models\Like::where('user_id', $user->id)->count();
        $playlistCount = \App\Models\Playlist::where('user_id', $user->id)->count();
        $followCount   = \App\Models\Follow::where('user_id', $user->id)->count();
        $application   = \App\Models\ArtistApplication::where('user_id', $user->id)->first();
        return view('library.profile', compact('likeCount', 'playlistCount', 'followCount', 'application'));
    }

    public function settings(): View
    {
        return view('library.settings');
    }

    public function myReports(): View
    {
        $reports = \App\Models\Report::where('user_id', auth()->id())
            ->with('reportable')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('library.my-reports', compact('reports'));
    }
}
