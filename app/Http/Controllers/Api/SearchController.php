<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $q = $request->get('q', '');

        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        return response()->json([
            'tracks' => Track::published()
                ->where('title', 'like', "%{$q}%")
                ->with(['artist:id,display_name,slug'])
                ->take(10)->get(),
            'artists' => Artist::where('display_name', 'like', "%{$q}%")
                ->take(5)->get(['id', 'display_name', 'slug']),
            'albums' => Album::published()
                ->where('title', 'like', "%{$q}%")
                ->with('artist:id,display_name')
                ->take(5)->get(),
        ]);
    }
}
