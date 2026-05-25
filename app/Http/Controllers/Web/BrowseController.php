<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Track;
use Illuminate\View\View;

class BrowseController extends Controller
{
    public function index(): View
    {
        $genres = Genre::active()->ordered()->get();
        $tracks = Track::published()
            ->with(['artist', 'album'])
            ->orderByDesc('play_count')
            ->paginate(24);

        return view('browse.index', compact('genres', 'tracks'));
    }

    public function genre(Genre $genre): View
    {
        $tracks = $genre->tracks()
            ->published()
            ->with(['artist', 'album'])
            ->orderByDesc('play_count')
            ->paginate(24);

        return view('browse.genre', compact('genre', 'tracks'));
    }
}
