<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BrowseController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\TrackController;
use App\Http\Controllers\Web\AlbumController;
use App\Http\Controllers\Web\ArtistController;
use App\Http\Controllers\Web\PlaylistController;
use App\Http\Controllers\Web\PodcastController;
use App\Http\Controllers\Web\LibraryController;
use App\Http\Controllers\Web\SubscriptionController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\PageController;
use App\Services\StreamService;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

// ── Public Routes ──
Route::get('/', HomeController::class)->name('home');
Route::get('/browse', [BrowseController::class, 'index'])->name('browse');
Route::get('/browse/genre/{genre}', [BrowseController::class, 'genre'])->name('browse.genre');
Route::get('/search', SearchController::class)->name('search');

Route::get('/track/{track}', [TrackController::class, 'show'])->name('track.show');

// Audio stream with byte-range support for seeking
Route::get('/stream/track/{track}', function (App\Models\Track $track) {
    $path = null;
    if ($track->file_path) {
        $path = storage_path('app/public/' . $track->file_path);
    }
    if (!$path || !file_exists($path)) {
        abort(404);
    }

    $size = filesize($path);
    $mime = 'audio/mpeg';
    $headers = [
        'Content-Type' => $mime,
        'Accept-Ranges' => 'bytes',
        'Cache-Control' => 'public, max-age=86400',
    ];

    $range = request()->header('Range');
    if ($range) {
        preg_match('/bytes=(\d+)-(\d*)/', $range, $matches);
        $start = intval($matches[1]);
        $end = isset($matches[2]) && $matches[2] !== '' ? intval($matches[2]) : $size - 1;
        $length = $end - $start + 1;

        $headers['Content-Range'] = "bytes {$start}-{$end}/{$size}";
        $headers['Content-Length'] = $length;

        $file = fopen($path, 'rb');
        fseek($file, $start);
        $data = fread($file, $length);
        fclose($file);

        return response($data, 206, $headers);
    }

    $headers['Content-Length'] = $size;
    return response()->file($path, $headers);
})->name('track.stream');
Route::get('/album/{album}', [AlbumController::class, 'show'])->name('album.show');
Route::get('/artist/{artist}', [ArtistController::class, 'show'])->name('artist.show');
Route::get('/playlist/{playlist}', [PlaylistController::class, 'show'])->name('playlist.show');
Route::get('/podcasts', [PodcastController::class, 'index'])->name('podcasts.index');
Route::get('/podcast/{podcast}', [PodcastController::class, 'show'])->name('podcast.show');

Route::get('/premium', [SubscriptionController::class, 'plans'])->name('premium');
Route::get('/page/{page}', [PageController::class, 'show'])->name('page.show');

// ── Auth Routes ──
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

// ── Authenticated Routes ──
Route::middleware('auth')->group(function () {
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::get('/library/liked', [LibraryController::class, 'liked'])->name('library.liked');
    Route::get('/library/playlists', [LibraryController::class, 'playlists'])->name('library.playlists');
    Route::get('/library/history', [LibraryController::class, 'history'])->name('library.history');
    Route::get('/profile', [LibraryController::class, 'profile'])->name('profile');
    Route::get('/settings', [LibraryController::class, 'settings'])->name('settings');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Stream recording (web version - session auth)
    Route::post('/stream/record', function (StreamService $streamService) {
        request()->validate([
            'track_id' => 'required|exists:tracks,id',
            'duration_listened' => 'required|integer|min:0',
            'completed' => 'boolean',
        ]);

        $track = \App\Models\Track::findOrFail(request('track_id'));

        $stream = $streamService->recordStream(auth()->user(), $track, [
            'duration_listened' => request('duration_listened'),
            'completed' => request('completed', false),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_type' => 'web',
        ]);

        $streamService->addToRecentlyPlayed(auth()->user(), $track, request('duration_listened'));

        return response()->json(['success' => true]);
    })->name('stream.record');

    // Post comment
    Route::post('/comment', function () {
        $validated = request()->validate([
            'commentable_type' => 'required|in:track,album,podcast',
            'commentable_id' => 'required|integer',
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|integer|exists:comments,id',
            'timestamp_at' => 'nullable|integer|min:0',
        ]);

        $types = [
            'track' => \App\Models\Track::class,
            'album' => \App\Models\Album::class,
            'podcast' => \App\Models\Podcast::class,
        ];

        $comment = \App\Models\Comment::create([
            'user_id' => auth()->id(),
            'commentable_type' => $types[$validated['commentable_type']],
            'commentable_id' => $validated['commentable_id'],
            'parent_id' => $validated['parent_id'] ?? null,
            'body' => $validated['body'],
            'timestamp_at' => $validated['timestamp_at'] ?? null,
            'is_approved' => true,
        ]);

        if (request()->wantsJson()) {
            $comment->load('user');
            return response()->json([
                'id' => $comment->id,
                'body' => $comment->body,
                'user' => $comment->user->name ?? 'کاربر',
                'timestamp_at' => $comment->timestamp_at,
                'created_at' => $comment->created_at->diffForHumans(),
            ]);
        }

        return back();
    })->name('comment.store');

    // Like/unlike comment
    Route::post('/comment/{comment}/like', function (\App\Models\Comment $comment) {
        $user = auth()->user();
        $like = \App\Models\Like::where('user_id', $user->id)
            ->where('likeable_type', \App\Models\Comment::class)
            ->where('likeable_id', $comment->id)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            \App\Models\Like::create([
                'user_id' => $user->id,
                'likeable_type' => \App\Models\Comment::class,
                'likeable_id' => $comment->id,
            ]);
            $liked = true;
        }

        $count = \App\Models\Like::where('likeable_type', \App\Models\Comment::class)
            ->where('likeable_id', $comment->id)->count();

        return response()->json(['liked' => $liked, 'count' => $count]);
    })->name('comment.like');

    // Add track to playlist
    Route::post('/playlist/add-track', function () {
        $validated = request()->validate([
            'playlist_id' => 'required|integer',
            'track_id' => 'required|integer|exists:tracks,id',
        ]);

        $playlist = auth()->user()->playlists()->findOrFail($validated['playlist_id']);

        if ($playlist->tracks()->where('track_id', $validated['track_id'])->exists()) {
            return response()->json(['added' => false, 'exists' => true]);
        }

        $maxPos = $playlist->tracks()->max('playlist_track.position') ?? 0;
        $playlist->tracks()->attach($validated['track_id'], [
            'position' => $maxPos + 1,
            'added_by' => auth()->id(),
        ]);
        $playlist->recalculate();

        return response()->json(['added' => true, 'exists' => false]);
    })->name('playlist.add-track');

    // Create playlist
    Route::post('/playlist/create', function () {
        $validated = request()->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $playlist = auth()->user()->playlists()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'visibility' => 'private',
        ]);

        return response()->json(['id' => $playlist->id, 'slug' => $playlist->slug]);
    })->name('playlist.create');

    // Like check
    Route::get('/like/check', function () {
        $validated = request()->validate([
            'type' => 'required|in:track,album,playlist,podcast_episode',
            'id' => 'required|integer',
        ]);

        $typeMap = [
            'track' => \App\Models\Track::class,
            'album' => \App\Models\Album::class,
            'playlist' => \App\Models\Playlist::class,
            'podcast_episode' => \App\Models\PodcastEpisode::class,
        ];

        $liked = auth()->user()->likes()
            ->where('likeable_type', $typeMap[$validated['type']])
            ->where('likeable_id', $validated['id'])
            ->exists();

        return response()->json(['liked' => $liked]);
    })->name('like.check');

    // Like toggle
    Route::post('/like/toggle', function () {
        $validated = request()->validate([
            'type' => 'required|in:track,album,playlist,podcast_episode',
            'id' => 'required|integer',
        ]);

        $typeMap = [
            'track' => \App\Models\Track::class,
            'album' => \App\Models\Album::class,
            'playlist' => \App\Models\Playlist::class,
            'podcast_episode' => \App\Models\PodcastEpisode::class,
        ];

        $likeableType = $typeMap[$validated['type']];
        $user = auth()->user();

        $existing = $user->likes()
            ->where('likeable_type', $likeableType)
            ->where('likeable_id', $validated['id'])
            ->first();

        if ($existing) {
            $existing->delete();
            if ($validated['type'] === 'track') {
                \App\Models\Track::where('id', $validated['id'])->decrement('like_count');
            }
            return response()->json(['liked' => false]);
        }

        $user->likes()->create([
            'likeable_type' => $likeableType,
            'likeable_id' => $validated['id'],
        ]);

        if ($validated['type'] === 'track') {
            \App\Models\Track::where('id', $validated['id'])->increment('like_count');
        }

        return response()->json(['liked' => true]);
    })->name('like.toggle');

    // Subscription
    Route::get('/subscription/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('/subscription/pay', [SubscriptionController::class, 'pay'])->name('subscription.pay');
    Route::get('/subscription/verify', [SubscriptionController::class, 'verify'])->name('subscription.verify');
});

// ── Artist Routes ──
Route::middleware(['auth'])->prefix('artist')->name('artist.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Artist\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tracks', [\App\Http\Controllers\Artist\TrackController::class, 'index'])->name('tracks');
    Route::get('/tracks/create', [\App\Http\Controllers\Artist\TrackController::class, 'create'])->name('tracks.create');
    Route::get('/albums', [\App\Http\Controllers\Artist\AlbumController::class, 'index'])->name('albums');
    Route::get('/analytics', [\App\Http\Controllers\Artist\AnalyticsController::class, 'index'])->name('analytics');
});
