<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\JsonResponse;

class AlbumController extends Controller
{
    public function show(Album $album): JsonResponse
    {
        $album->load(['artist', 'tracks.artist', 'genre']);
        return response()->json($album);
    }
}
