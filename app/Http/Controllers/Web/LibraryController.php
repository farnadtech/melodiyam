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
        $playlists = auth()->user()->playlists()
            ->withCount('tracks')
            ->latest()
            ->get();

        return view('library.playlists', compact('playlists'));
    }

    public function history(): View
    {
        $history = auth()->user()->recentlyPlayed()
            ->with('playable')
            ->take(50)
            ->get();

        return view('library.history', compact('history'));
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
