<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Services\StreamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    public function store(Request $request, StreamService $streamService): JsonResponse
    {
        $request->validate([
            'track_id' => 'required|exists:tracks,id',
            'duration_listened' => 'required|integer|min:0',
            'completed' => 'boolean',
        ]);

        $track = Track::findOrFail($request->track_id);

        $stream = $streamService->recordStream($request->user(), $track, [
            'duration_listened' => $request->duration_listened,
            'completed' => $request->completed ?? false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_type' => $request->header('X-Device-Type', 'web'),
        ]);

        $streamService->addToRecentlyPlayed($request->user(), $track, $request->duration_listened);

        return response()->json(['success' => true, 'stream_id' => $stream->id]);
    }
}
