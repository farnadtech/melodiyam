<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Sale;
use App\Models\Album;
use Illuminate\View\View;

class TrackController extends Controller
{
    public function show(Track $track): View
    {
        $track->load(['artist', 'album', 'genres', 'featuringArtists']);

        $user = auth()->user();
        $hasPlanAccess = $user?->activeSubscription?->plan?->includes_paid_content ?? false;
        $canPlay = true;

        $album = $track->album;
        $trackHasOwnPrice = $track->is_for_sale && $track->price;
        $albumIsPaid = $album && $album->is_for_sale && $album->price;

        // Effectively paid: own price OR belongs to paid album without own price
        $isPaidTrack = $trackHasOwnPrice || ($albumIsPaid && !$trackHasOwnPrice);

        // Preview: track's own preview_seconds, fallback to album's
        $previewSec = ($track->preview_seconds ?? 0) > 0
            ? $track->preview_seconds
            : ($albumIsPaid ? ($album->preview_seconds ?? 0) : 0);

        // Purchase URL and effective price
        if ($trackHasOwnPrice) {
            $buyUrl   = route('purchase', ['type' => 'track', 'id' => $track->id]);
            $sellPrice      = $track->price;
            $sellDiscount   = $track->discount_price;
        } elseif ($albumIsPaid) {
            $buyUrl   = route('purchase', ['type' => 'album', 'id' => $album->id]);
            $sellPrice      = $album->price;
            $sellDiscount   = $album->discount_price;
        } else {
            $buyUrl       = null;
            $sellPrice    = null;
            $sellDiscount = null;
        }

        if ($isPaidTrack) {
            if (!$user) {
                $canPlay = false;
            } elseif (!$hasPlanAccess) {
                $canPlay = Sale::where('buyer_id', $user->id)
                    ->where('status', 'completed')
                    ->where(function ($q) use ($track, $album) {
                        $q->where(function ($q2) use ($track) {
                            $q2->where('saleable_type', Track::class)
                               ->where('saleable_id', $track->id);
                        });
                        if ($album) {
                            $q->orWhere(function ($q2) use ($album) {
                                $q2->where('saleable_type', Album::class)
                                   ->where('saleable_id', $album->id);
                            });
                        }
                    })->exists();
            }
        }

        $relatedTracks = Track::published()
            ->where('id', '!=', $track->id)
            ->where(function ($q) use ($track) {
                $q->where('artist_id', $track->artist_id)
                  ->orWhere('genre_id', $track->genre_id);
            })
            ->with(['artist'])
            ->take(8)
            ->get();

        $comments = $track->comments()
            ->approved()
            ->roots()
            ->with(['user', 'replies' => fn($q) => $q->approved()->with('user')->latest()])
            ->withCount(['likes' => fn($q) => $q->where('likeable_type', \App\Models\Comment::class)])
            ->latest()
            ->get();

        // Attach user's like status
        if (auth()->check()) {
            $likedIds = \App\Models\Like::where('user_id', auth()->id())
                ->where('likeable_type', \App\Models\Comment::class)
                ->whereIn('likeable_id', $comments->pluck('id'))
                ->pluck('likeable_id')
                ->toArray();
            $comments->each(fn($c) => $c->user_liked = in_array($c->id, $likedIds));
        } else {
            $comments->each(fn($c) => $c->user_liked = false);
        }

        // Check if user liked this track
        $userLikedTrack = false;
        if (auth()->check()) {
            $userLikedTrack = \App\Models\Like::where('user_id', auth()->id())
                ->where('likeable_type', Track::class)
                ->where('likeable_id', $track->id)
                ->exists();
        }

        return view('track.show', compact(
            'track', 'relatedTracks', 'comments', 'userLikedTrack', 'canPlay',
            'isPaidTrack', 'previewSec', 'buyUrl', 'sellPrice', 'sellDiscount'
        ));
    }
}
