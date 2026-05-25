<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $artist = auth()->user()->artist;
        return view('artist.analytics', compact('artist'));
    }
}
