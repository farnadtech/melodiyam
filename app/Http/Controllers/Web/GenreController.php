<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('tracks')->orderBy('tracks_count', 'desc')->get();
        return view('genre.index', compact('genres'));
    }

    public function show(Genre $genre)
    {
        $tracks = $genre->tracks()->where('status', 'published')->latest()->paginate(24);
        return view('genre.show', compact('genre', 'tracks'));
    }
}
