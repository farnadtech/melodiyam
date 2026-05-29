<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Sale;
use App\Models\Track;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function index(): View
    {
        $sort = request('sort', 'newest');

        $albums = Album::with('artist')
            ->where('status', 'published')
            ->withCount('tracks')
            ->sort($sort)
            ->paginate(24);

        return view('album.index', compact('albums', 'sort'));
    }

    public function show(Album $album): View
    {
        $sort = request('sort', 'newest');
        $album->load(['artist', 'genre']);
        
        $tracks = $album->tracks()
            ->with('artist')
            ->sort($sort)
            ->get();

        $user = auth()->user();
        $hasPlanAccess = $user && $user->activeSubscription?->plan?->includes_paid_content;

        // IDs of tracks/albums this user already bought
        $purchasedTrackIds = [];
        $purchasedAlbumIds = [];
        $albumAlreadyBought = false;
        $userLikedAlbum = false;

        if ($user) {
            $userLikedAlbum = $user->likes()
                ->where('likeable_type', Album::class)
                ->where('likeable_id', $album->id)
                ->exists();

            $purchasedTrackIds = Sale::where('buyer_id', $user->id)
                ->where('saleable_type', Track::class)
                ->where('status', 'completed')
                ->pluck('saleable_id')->toArray();

            $albumAlreadyBought = Sale::where('buyer_id', $user->id)
                ->where('saleable_type', Album::class)
                ->where('saleable_id', $album->id)
                ->where('status', 'completed')
                ->exists();
        }

        return view('album.show', compact(
            'album', 'tracks', 'sort', 'hasPlanAccess',
            'purchasedTrackIds', 'albumAlreadyBought', 'userLikedAlbum'
        ));
    }
}
