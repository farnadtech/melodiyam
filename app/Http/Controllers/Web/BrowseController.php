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
        $sortBy      = $request->input('sort', 'newest');
        
        // Normalize sort keys
        $sortMap = [
            'play_count' => 'most_played',
            'like_count' => 'most_popular',
        ];
        $sortBy = $sortMap[$sortBy] ?? $sortBy;

        $genreSlugs  = array_filter((array) $request->input('genre', []));

        $query = Track::published()->with(['artist', 'album']);

        if (!empty($genreSlugs)) {
            $genreIds = \App\Models\Genre::whereIn('slug', $genreSlugs)->pluck('id');
            $query->where(function ($q) use ($genreIds, $genreSlugs) {
                $q->whereIn('genre_id', $genreIds)
                  ->orWhereHas('genres', fn ($gq) => $gq->whereIn('slug', $genreSlugs));
            });
        }

        $tracks = $query->sort($sortBy)->paginate(24)->withQueryString();

        $activeGenres = $genreSlugs;

        return view('browse.index', compact('genres', 'tracks', 'activeGenres', 'sortBy'));
    }

    public function genre(Genre $genre, Request $request): View
    {
        $sortBy = $request->input('sort', 'newest');
        
        $tracks = Track::published()->with(['artist', 'album'])
            ->where(function ($q) use ($genre) {
                $q->where('genre_id', $genre->id)
                  ->orWhereHas('genres', fn ($gq) => $gq->where('genres.id', $genre->id));
            })
            ->sort($sortBy)
            ->paginate(24)
            ->withQueryString();

        return view('browse.genre', compact('genre', 'tracks', 'sortBy'));
    }

    public function tracksJson(Request $request)
    {
        $sortBy      = $request->input('sort', 'newest');
        $genreSlugs  = array_filter((array) $request->input('genre', []));

        $query = Track::published()->with(['artist', 'album']);

        if (!empty($genreSlugs)) {
            $genreIds = Genre::whereIn('slug', $genreSlugs)->pluck('id');
            $query->where(function ($q) use ($genreIds, $genreSlugs) {
                $q->whereIn('genre_id', $genreIds)
                  ->orWhereHas('genres', fn ($gq) => $gq->whereIn('slug', $genreSlugs));
            });
        }

        $tracks = $query->sort($sortBy)->paginate(24)->withQueryString();

        return response()->json([
            'tracks'   => $tracks->map(fn($t) => $this->trackData($t)),
            'has_more' => $tracks->hasMorePages(),
            'next_page'=> $tracks->currentPage() + 1,
        ]);
    }

    public function genreTracksJson(Genre $genre, Request $request)
    {
        $sortBy       = $request->input('sort', 'newest');

        $tracks = Track::published()->with(['artist', 'album'])
            ->where(function ($q) use ($genre) {
                $q->where('genre_id', $genre->id)
                  ->orWhereHas('genres', fn ($gq) => $gq->where('genres.id', $genre->id));
            })
            ->sort($sortBy)
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
        $user = auth()->user();
        $isPremiumUser = $user?->isPremium() ?? false;
        $isPremiumOnly = (bool) $track->is_premium_only;
        $premiumPreviewSec = $isPremiumOnly && !$isPremiumUser
            ? (int) \App\Models\Setting::get('premium_preview_seconds', 30)
            : 0;
        $isPaid = !$isPremiumOnly && $track->is_for_sale && $track->price;
        $previewSec = $track->preview_seconds ?? 0;
        $canPlay = (!$isPremiumOnly || $isPremiumUser) && !$isPaid;
        $price = $track->discount_price ?: $track->price;

        return [
            'id'               => $track->id,
            'title'            => $track->title,
            'artist'           => $track->artist?->display_name ?? $track->artist?->name,
            'cover'            => $track->getCoverUrl(),
            'url'              => $track->getStreamUrl(),
            'cover_page'       => route('track.show', $track->slug),
            'artist_url'       => $track->artist ? route('artist.show', $track->artist->slug) : null,
            'duration'         => $track->duration ?? 0,
            'isPremiumOnly'    => $isPremiumOnly,
            'premiumPreviewSec'=> $premiumPreviewSec,
            'isPaid'           => $isPaid,
            'previewSeconds'   => $isPremiumOnly ? $premiumPreviewSec : $previewSec,
            'canPlay'          => $canPlay,
            'isPremium'        => $isPremiumOnly && !$isPremiumUser,
            'price'            => $price,
            'purchaseUrl'      => $isPremiumOnly
                ? route('premium')
                : route('purchase', ['type' => 'track', 'id' => $track->id]),
        ];
    }
}
