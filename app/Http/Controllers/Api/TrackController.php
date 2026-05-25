<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tracks = Track::published()
            ->with(['artist:id,display_name,slug', 'album:id,title,cover_image'])
            ->when($request->genre, fn($q) => $q->where('genre_id', $request->genre))
            ->when($request->sort === 'popular', fn($q) => $q->orderByDesc('play_count'))
            ->when($request->sort === 'new', fn($q) => $q->orderByDesc('release_date'))
            ->paginate($request->per_page ?? 20);

        return response()->json($tracks);
    }

    public function show(Track $track): JsonResponse
    {
        $track->load(['artist', 'album', 'genres']);
        return response()->json($track);
    }
}
