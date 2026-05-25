<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\InteractionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function toggleLike(Request $request, InteractionService $service): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:track,album,playlist,episode',
            'id' => 'required|integer',
        ]);

        $model = match ($request->type) {
            'track' => \App\Models\Track::findOrFail($request->id),
            'album' => \App\Models\Album::findOrFail($request->id),
            'playlist' => \App\Models\Playlist::findOrFail($request->id),
            'episode' => \App\Models\PodcastEpisode::findOrFail($request->id),
        };

        $liked = $service->toggleLike($request->user(), $model);

        return response()->json(['liked' => $liked]);
    }

    public function toggleFollow(Request $request, InteractionService $service): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:artist,playlist,podcast',
            'id' => 'required|integer',
        ]);

        $model = match ($request->type) {
            'artist' => \App\Models\Artist::findOrFail($request->id),
            'playlist' => \App\Models\Playlist::findOrFail($request->id),
            'podcast' => \App\Models\Podcast::findOrFail($request->id),
        };

        $followed = $service->toggleFollow($request->user(), $model);

        return response()->json(['followed' => $followed]);
    }
}
