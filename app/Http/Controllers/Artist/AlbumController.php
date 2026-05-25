<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function index(): View
    {
        $albums = auth()->user()->artist?->albums()
            ->withCount('tracks')
            ->latest()
            ->paginate(20);

        return view('artist.albums.index', compact('albums'));
    }
}
