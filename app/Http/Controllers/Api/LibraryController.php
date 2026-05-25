<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function liked(Request $request): JsonResponse
    {
        $likes = $request->user()->likes()
            ->where('likeable_type', \App\Models\Track::class)
            ->with('likeable.artist:id,display_name,slug')
            ->latest('created_at')
            ->paginate(20);

        return response()->json($likes);
    }

    public function playlists(Request $request): JsonResponse
    {
        $playlists = $request->user()->playlists()
            ->withCount('tracks')
            ->latest()
            ->get();

        return response()->json($playlists);
    }

    public function history(Request $request): JsonResponse
    {
        $history = $request->user()->recentlyPlayed()
            ->with('playable')
            ->take(50)
            ->get();

        return response()->json($history);
    }
}
