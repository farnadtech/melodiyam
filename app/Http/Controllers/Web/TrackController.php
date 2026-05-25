<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\View\View;

class TrackController extends Controller
{
    public function show(Track $track): View
    {
        $track->load(['artist', 'album', 'genres', 'featuringArtists']);

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

        return view('track.show', compact('track', 'relatedTracks', 'comments', 'userLikedTrack'));
    }
}
