<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $artist = $user->artist;

        if (!$artist) {
            return view('artist.request-verification');
        }

        $totalStreams = $artist->total_streams;
        $totalTracks = $artist->tracks()->count();
        $totalAlbums = $artist->albums()->count();
        $followers = $artist->followers_count;

        return view('artist.dashboard', compact('artist', 'totalStreams', 'totalTracks', 'totalAlbums', 'followers'));
    }
}
