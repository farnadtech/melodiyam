<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\JsonResponse;

class ArtistController extends Controller
{
    public function show(Artist $artist): JsonResponse
    {
        $artist->load('user:id,name,avatar');
        $artist->loadCount(['tracks', 'albums']);
        return response()->json($artist);
    }
}
