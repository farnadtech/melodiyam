<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrowseController extends Controller
{
    public function index(Request $request): View
    {
        $genres      = Genre::active()->ordered()->get();
        $sortBy      = $request->input('sort', 'play_count');
        $genreSlugs  = array_filter((array) $request->input('genre', []));

        $query = Track::published()->with(['artist', 'album']);

        if (!empty($genreSlugs)) {
            $genreIds = \App\Models\Genre::whereIn('slug', $genreSlugs)->pluck('id');
            $query->where(function ($q) use ($genreIds, $genreSlugs) {
                $q->whereIn('genre_id', $genreIds)
                  ->orWhereHas('genres', fn ($gq) => $gq->whereIn('slug', $genreSlugs));
            });
        }

        $allowedSorts = ['play_count', 'release_date', 'created_at'];
        $query->orderByDesc(in_array($sortBy, $allowedSorts) ? $sortBy : 'play_count');

        $tracks = $query->paginate(24)->withQueryString();

        $activeGenres = $genreSlugs;

        return view('browse.index', compact('genres', 'tracks', 'activeGenres', 'sortBy'));
    }

    public function tracksJson(Request $request)
    {
        $sortBy      = $request->input('sort', 'play_count');
        $genreSlugs  = array_filter((array) $request->input('genre', []));
        $allowedSorts = ['play_count', 'release_date', 'created_at'];

        $query = Track::published()->with(['artist', 'album']);

        if (!empty($genreSlugs)) {
            $genreIds = Genre::whereIn('slug', $genreSlugs)->pluck('id');
            $query->where(function ($q) use ($genreIds, $genreSlugs) {
                $q->whereIn('genre_id', $genreIds)
                  ->orWhereHas('genres', fn ($gq) => $gq->whereIn('slug', $genreSlugs));
            });
        }

        $query->orderByDesc(in_array($sortBy, $allowedSorts) ? $sortBy : 'play_count');
        $tracks = $query->paginate(24)->withQueryString();

        return response()->json([
            'tracks'   => $tracks->map(fn($t) => $this->trackData($t)),
            'has_more' => $tracks->hasMorePages(),
            'next_page'=> $tracks->currentPage() + 1,
        ]);
    }

    public function genreTracksJson(Genre $genre, Request $request)
    {
        $sortBy       = $request->input('sort', 'play_count');
        $allowedSorts = ['play_count', 'release_date', 'created_at'];

        $tracks = Track::published()->with(['artist', 'album'])
            ->where(function ($q) use ($genre) {
                $q->where('genre_id', $genre->id)
                  ->orWhereHas('genres', fn ($gq) => $gq->where('genres.id', $genre->id));
            })
            ->orderByDesc(in_array($sortBy, $allowedSorts) ? $sortBy : 'play_count')
            ->paginate(24)
            ->withQueryString();

        return response()->json([
            'tracks'    => $tracks->map(fn($t) => $this->trackData($t)),
            'has_more'  => $tracks->hasMorePages(),
            'next_page' => $tracks->currentPage() + 1,
        ]);
    }

    private function trackData(Track $track): array
    {
        return [
            'id'         => $track->id,
            'title'      => $track->title,
            'artist'     => $track->artist?->name ?? $track->artist?->display_name,
            'cover'      => $track->getCoverUrl(),
            'url'        => $track->getStreamUrl(),
            'cover_page' => route('track.show', $track->slug),
        ];
    }

    public function genre(Genre $genre, Request $request): View
    {
        $sortBy       = $request->input('sort', 'play_count');
        $allowedSorts = ['play_count', 'release_date', 'created_at'];
        $orderCol     = in_array($sortBy, $allowedSorts) ? $sortBy : 'play_count';

        $tracks = Track::published()
            ->with(['artist', 'album'])
            ->where(function ($q) use ($genre) {
                $q->where('genre_id', $genre->id)
                  ->orWhereHas('genres', fn ($gq) => $gq->where('genres.id', $genre->id));
            })
            ->orderByDesc($orderCol)
            ->paginate(24)
            ->withQueryString();

        return view('browse.genre', compact('genre', 'tracks', 'sortBy'));
    }
}
