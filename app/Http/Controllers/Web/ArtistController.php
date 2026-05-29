<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\View\View;

class ArtistController extends Controller
{
    public function dashboard(): View
    {
        $artist = auth()->user()->artist;

        if (!$artist) {
            abort(403, 'پروفایل هنرمند یافت نشد');
        }

        $stats = [
            'total_tracks' => $artist->tracks()->count(),
            'published_tracks' => $artist->tracks()->published()->count(),
            'total_streams' => $artist->total_streams,
            'monthly_listeners' => $artist->monthly_listeners,
            'followers_count' => $artist->followers_count,
        ];

        $recentTracks = $artist->tracks()
            ->latest()
            ->limit(5)
            ->get();

        $albums = $artist->albums()
            ->latest()
            ->limit(5)
            ->get();

        return view('artist.dashboard', compact('artist', 'stats', 'recentTracks', 'albums'));
    }

    public function show(Artist $artist): View
    {
        $artist->load('user');
        $sort = request('sort', 'newest');

        $tracks = $artist->tracks()
            ->published()
            ->sort($sort)
            ->paginate(24)
            ->withQueryString();

        $albums = $artist->albums()
            ->published()
            ->orderByDesc('release_date')
            ->get();

        return view('artist.show', compact('artist', 'tracks', 'albums', 'sort'));
    }
}
