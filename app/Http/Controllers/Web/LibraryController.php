<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'amount' => 'required|numeric',
            'category' => 'nullable|string'
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json(['error' => 'کد تخفیف معتبر نیست.'], 422);
        }

        if (!$coupon->isValidForUser(auth()->user(), $request->category, $request->amount)) {
            return response()->json(['error' => 'شما مجاز به استفاده از این کد تخفیف نیستید یا شرایط آن را ندارید.'], 422);
        }

        $discount = $coupon->calculateDiscount($request->amount);

        return response()->json([
            'discount' => $discount,
            'final_amount' => $request->amount - $discount,
            'message' => 'کد تخفیف با موفقیت اعمال شد.'
        ]);
    }
    public function index(): View
    {
        return view('library.index');
    }

    public function liked(): View
    {
        $sort = request('sort', 'newest');
        
        $tracks = \App\Models\Track::join('likes', 'tracks.id', '=', 'likes.likeable_id')
            ->where('likes.user_id', auth()->id())
            ->where('likes.likeable_type', \App\Models\Track::class)
            ->select('tracks.*', 'likes.created_at as liked_at')
            ->with('artist');

        if ($sort === 'newest') {
            $tracks->orderByDesc('liked_at');
        } elseif ($sort === 'oldest') {
            $tracks->orderBy('liked_at');
        } else {
            $tracks->sort($sort);
        }

        $tracks = $tracks->paginate(50);

        return view('library.liked', compact('tracks', 'sort'));
    }

    public function playlists(): View
    {
        $myPlaylists = auth()->user()->playlists()
            ->withCount('tracks')
            ->latest()
            ->get();

        $savedPlaylists = auth()->user()->likes()
            ->where('likeable_type', \App\Models\Playlist::class)
            ->with('likeable.user')
            ->latest()
            ->get()
            ->pluck('likeable')
            ->filter();

        return view('library.playlists', compact('myPlaylists', 'savedPlaylists'));
    }

    public function history(): View
    {
        $history = auth()->user()->recentlyPlayed()
            ->with('playable')
            ->take(50)
            ->get();

        return view('library.history', compact('history'));
    }

    public function albums(): View
    {
        $albums = auth()->user()->likes()
            ->where('likeable_type', \App\Models\Album::class)
            ->with('likeable.artist')
            ->latest()
            ->get()
            ->pluck('likeable')
            ->filter();

        return view('library.albums', compact('albums'));
    }

    public function artists(): View
    {
        $artists = auth()->user()->follows()
            ->where('followable_type', \App\Models\Artist::class)
            ->with('followable')
            ->latest()
            ->get()
            ->pluck('followable')
            ->filter();

        return view('library.artists', compact('artists'));
    }

    public function podcasts(): View
    {
        $podcasts = auth()->user()->subscribedPodcasts()
            ->with('artist')
            ->orderByDesc('subscribers_count')
            ->get();

        return view('library.podcasts', compact('podcasts'));
    }

    public function downloads(): View
    {
        $sort = request('sort', 'newest');

        $downloads = \App\Models\Download::where('user_id', auth()->id())
            ->with(['downloadable.artist'])
            ->select('*');

        if ($sort === 'newest') {
            $downloads->orderByDesc('created_at');
        } elseif ($sort === 'oldest') {
            $downloads->orderBy('created_at');
        }

        $items = $downloads->paginate(50);

        return view('library.downloads', compact('items', 'sort'));
    }

    public function queue(): View
    {
        return view('library.queue');
    }

    public function wallet(): View
    {
        return view('library.wallet');
    }

    public function discover(): View
    {
        $newReleases = \App\Models\Track::with('artist')
            ->latest()
            ->take(20)
            ->get();

        $topArtists = \App\Models\Artist::orderByDesc('followers_count')
            ->take(12)
            ->get();

        $newAlbums = \App\Models\Album::with('artist')
            ->where('status', 'published')
            ->latest()
            ->take(12)
            ->get();

        return view('discover', compact('newReleases', 'topArtists', 'newAlbums'));
    }

    public function profile(): View
    {
        $user = auth()->user();
        $likeCount     = \App\Models\Like::where('user_id', $user->id)->count();
        $playlistCount = \App\Models\Playlist::where('user_id', $user->id)->count();
        $followCount   = \App\Models\Follow::where('user_id', $user->id)->count();
        $application   = \App\Models\ArtistApplication::where('user_id', $user->id)->first();
        $activeSubscription = $user->activeSubscription()->with('plan')->first();
        
        return view('library.profile', compact('likeCount', 'playlistCount', 'followCount', 'application', 'activeSubscription'));
    }

    public function settings(): View
    {
        return view('library.settings');
    }

    public function myReports(): View
    {
        $reports = \App\Models\Report::where('user_id', auth()->id())
            ->with('reportable')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('library.my-reports', compact('reports'));
    }
}
