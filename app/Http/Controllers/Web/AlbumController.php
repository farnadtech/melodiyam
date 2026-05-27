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
        $albums = Album::with('artist')
            ->where('status', 'published')
            ->withCount('tracks')
            ->latest()
            ->paginate(24);

        return view('album.index', compact('albums'));
    }

    public function show(Album $album): View
    {
        $album->load(['artist', 'tracks.artist', 'genre']);

        $user = auth()->user();
        $hasPlanAccess = $user && $user->activeSubscription?->plan?->includes_paid_content;

        // IDs of tracks/albums this user already bought
        $purchasedTrackIds = [];
        $purchasedAlbumIds = [];
        $albumAlreadyBought = false;

        if ($user) {
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
            'album', 'hasPlanAccess',
            'purchasedTrackIds', 'albumAlreadyBought'
        ));
    }
}
