<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\View\View;

class PlaylistController extends Controller
{
    public function show(Playlist $playlist): View
    {
        $playlist->load(['user', 'tracks.artist']);
        return view('playlist.show', compact('playlist'));
    }
}
