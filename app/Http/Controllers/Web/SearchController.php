<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = $request->get('q');
        $results = [];

        if ($query) {
            $results = [
                'tracks' => Track::published()
                    ->where('title', 'like', "%{$query}%")
                    ->orWhere('title_en', 'like', "%{$query}%")
                    ->with(['artist', 'album'])
                    ->take(12)
                    ->get(),
                'artists' => Artist::where('display_name', 'like', "%{$query}%")
                    ->where('verification_status', 'approved')
                    ->take(6)
                    ->get(),
                'albums' => Album::published()
                    ->where('title', 'like', "%{$query}%")
                    ->with('artist')
                    ->take(6)
                    ->get(),
                'playlists' => Playlist::public()
                    ->where('title', 'like', "%{$query}%")
                    ->take(6)
                    ->get(),
            ];
        }

        return view('search.index', compact('query', 'results'));
    }
}
