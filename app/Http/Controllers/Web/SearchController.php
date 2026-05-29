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
        $sort = $request->get('sort', 'newest');
        $results = [];

        if ($query) {
            $results = [
                'tracks' => Track::published()
                    ->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                          ->orWhere('title_en', 'like', "%{$query}%");
                    })
                    ->sort($sort)
                    ->with(['artist', 'album'])
                    ->take(24)
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

        return view('search.index', compact('query', 'results', 'sort'));
    }
}
