<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TrackController extends Controller
{
    public function index(): View
    {
        $tracks = auth()->user()->artist?->tracks()
            ->with('album')
            ->latest()
            ->paginate(20);

        return view('artist.tracks.index', compact('tracks'));
    }

    public function create(): View
    {
        return view('artist.tracks.create');
    }
}
