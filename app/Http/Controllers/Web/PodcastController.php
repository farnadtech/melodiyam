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
            ->with('artist')
            ->orderByDesc('subscribers_count')
            ->paginate(24);

        return view('podcast.index', compact('podcasts'));
    }

    public function show(Podcast $podcast): View
    {
        $podcast->load(['artist', 'episodes' => fn($q) => $q->published()->orderBy('season_number', 'desc')->orderBy('episode_number', 'desc')]);
        $isPremiumUser = auth()->user()?->isPremium() ?? false;
        $premiumPreviewSec = (int) \App\Models\Setting::get('premium_preview_seconds', 30);
        return view('podcast.show', compact('podcast', 'isPremiumUser', 'premiumPreviewSec'));
    }
}
