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
    public function index(Request $request): View
    {
        $query = Podcast::published()->with('artist');

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $podcasts = $query->orderByDesc('subscribers_count')
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

        $userRepostedPodcast = false;
        $userLikedPodcast = false;
        $userRepostedEpisodes = [];

        if (auth()->check()) {
            $userRepostedPodcast = \App\Models\Repost::where('user_id', auth()->id())
                ->where('repostable_type', Podcast::class)
                ->where('repostable_id', $podcast->id)
                ->exists();

            $userLikedPodcast = \App\Models\Like::where('user_id', auth()->id())
                ->where('likeable_type', Podcast::class)
                ->where('likeable_id', $podcast->id)
                ->exists();

            $userRepostedEpisodes = \App\Models\Repost::where('user_id', auth()->id())
                ->where('repostable_type', PodcastEpisode::class)
                ->whereIn('repostable_id', $episodes->pluck('id'))
                ->pluck('repostable_id')
                ->toArray();
        }

        $title = $podcast->title;
        $metaDescription = mb_substr(strip_tags($podcast->description), 0, 160);
        $ogImage = $podcast->cover_url;
        $ogType = 'video.episode'; // Close enough for podcasts
        
        return view('podcast.show', compact(
            'podcast', 'episodes', 'sort', 'isPremiumUser', 'premiumPreviewSec', 
            'isSubscribed', 'canDownload', 'userRepostedPodcast', 'userLikedPodcast', 'userRepostedEpisodes',
            'title', 'metaDescription', 'ogImage', 'ogType'
        ));
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
