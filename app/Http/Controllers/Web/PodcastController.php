<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\View\View;

class PodcastController extends Controller
{
    public function index(): View
    {
        $podcasts = Podcast::published()
            ->with('user')
            ->orderByDesc('subscribers_count')
            ->paginate(24);

        return view('podcast.index', compact('podcasts'));
    }

    public function show(Podcast $podcast): View
    {
        $podcast->load(['user', 'episodes' => fn($q) => $q->published()]);
        return view('podcast.show', compact('podcast'));
    }
}
