<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\View\View;

class ArtistController extends Controller
{
    public function show(Artist $artist): View
    {
        $artist->load('user');

        $topTracks = $artist->tracks()
            ->published()
            ->orderByDesc('play_count')
            ->take(10)
            ->get();

        $albums = $artist->albums()
            ->published()
            ->orderByDesc('release_date')
            ->get();

        return view('artist.show', compact('artist', 'topTracks', 'albums'));
    }
}
