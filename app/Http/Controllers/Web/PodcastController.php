<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\PodcastSubscription;
use App\Models\PodcastEpisode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $sort = request('sort', 'newest');
        $podcast->load(['artist']);
        
        $episodes = $podcast->episodes()
            ->published()
            ->sort($sort)
            ->get();

        $isPremiumUser = auth()->user()?->isPremium() ?? false;
        $premiumPreviewSec = (int) \App\Models\Setting::get('premium_preview_seconds', 30);
        $isSubscribed = auth()->check() ? $podcast->subscriptions()->where('user_id', auth()->id())->exists() : false;
        $canDownload = auth()->user()?->canDownload() ?? false;
        
        return view('podcast.show', compact('podcast', 'episodes', 'sort', 'isPremiumUser', 'premiumPreviewSec', 'isSubscribed', 'canDownload'));
    }

    public function toggleSubscription(Request $request, Podcast $podcast): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $subscription = PodcastSubscription::where('user_id', auth()->id())
            ->where('podcast_id', $podcast->id)
            ->first();

        if ($subscription) {
            $subscription->delete();
            $podcast->decrement('subscribers_count');
            return response()->json(['subscribed' => false, 'count' => $podcast->fresh()->subscribers_count]);
        } else {
            PodcastSubscription::create([
                'user_id' => auth()->id(),
                'podcast_id' => $podcast->id,
            ]);
            $podcast->increment('subscribers_count');
            return response()->json(['subscribed' => true, 'count' => $podcast->fresh()->subscribers_count]);
        }
    }

    public function downloadEpisode(PodcastEpisode $episode)
    {
        $user = auth()->user();

        if (!$user || !$user->canDownload() || !$episode->is_downloadable) {
            abort(403, 'شما اجازه دانلود این قسمت را ندارید.');
        }

        // Record download
        \App\Models\Download::firstOrCreate([
            'user_id' => $user->id,
            'downloadable_type' => PodcastEpisode::class,
            'downloadable_id' => $episode->id,
        ]);

        // Increment play/download count (podcasts often use play_count for both)
        $episode->increment('play_count');

        // Get file path
        $path = $episode->getEffectiveStreamPath();

        if (!$path) {
            abort(404, 'فایل پادکست یافت نشد.');
        }

        return response()->download($path, $episode->title . '.' . pathinfo($path, PATHINFO_EXTENSION));
    }
}
