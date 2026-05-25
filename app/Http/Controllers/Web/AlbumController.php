<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function show(Album $album): View
    {
        $album->load(['artist', 'tracks.artist', 'genre']);
        return view('album.show', compact('album'));
    }
}
