<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Web\GenreController;
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
use App\Http\Controllers\Web\WalletController;
use App\Http\Controllers\Web\AdController;
use App\Http\Controllers\Web\PurchaseController;
use App\Http\Controllers\Web\PageController;
use App\Services\StreamService;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;

// ── Public Routes ──

// PWA manifest (primary route + fallback for deployment manifest collision)
Route::get('/pwa-manifest.json', \App\Http\Controllers\Web\ManifestController::class)->name('pwa.manifest');
Route::get('/manifest.json', \App\Http\Controllers\Web\ManifestController::class)->name('pwa.manifest.fallback');

// PWA debug page
Route::get('/pwa-debug', \App\Http\Controllers\Web\PwaDebugController::class)->name('pwa.debug');

// DEBUG: Test login
Route::get('/test-login', function () {
    $email = request('email', 'user@melodiyam.ir');
    $password = request('password', 'password');

    $user = \App\Models\User::where('email', $email)->first();

    if (!$user) {
        return "User not found: $email";
    }

    $output = "=== User Found ===\n";
    $output .= "Email: " . $user->email . "\n";
    $output .= "Name: " . $user->name . "\n";
    $output .= "Type: " . $user->type . "\n";
    $output .= "is_active: " . ($user->is_active ? 'YES' : 'NO') . "\n";
    $output .= "email_verified_at: " . ($user->email_verified_at ?? 'NULL') . "\n";
    $output .= "Password hash: " . substr($user->password, 0, 30) . "...\n";
    $output .= "Hash check: " . (Hash::check($password, $user->password) ? 'PASS' : 'FAIL') . "\n";

    $auth = Auth::attempt(['email' => $email, 'password' => $password], true);
    $output .= "Auth::attempt: " . ($auth ? 'SUCCESS' : 'FAILED') . "\n";

    return nl2br($output);
});

// ── Audio Ad API (used by player) ──
Route::get('/api/audio-ad', [\App\Http\Controllers\Web\AdController::class, 'getAudioAd'])->name('api.audio-ad');
Route::get('/api/banner-ad', [\App\Http\Controllers\Web\AdController::class, 'getBannerAd'])->name('api.banner-ad');
Route::post('/api/ad-click', [\App\Http\Controllers\Web\AdController::class, 'trackClick'])->name('ad.click.public');

Route::get('/', HomeController::class)->name('home');

Route::get('/genres', [GenreController::class, 'index'])->name('genre.index');
Route::get('/genre/{genre:slug}', [GenreController::class, 'show'])->name('genre.show');
Route::get('/browse', [BrowseController::class, 'index'])->name('browse');
Route::get('/browse/tracks.json', [BrowseController::class, 'tracksJson'])->name('browse.tracks.json');
Route::get('/browse/genre/{genre:slug}/tracks.json', [BrowseController::class, 'genreTracksJson'])->name('browse.genre.tracks.json');
Route::get('/browse/genre/{genre:slug}', [BrowseController::class, 'genre'])->name('browse.genre');
Route::get('/search', SearchController::class)->name('search');
Route::get('/feed', \App\Livewire\Feed::class)->middleware(['auth'])->name('feed');

// ── Interactions ──
Route::middleware(['auth'])->group(function () {
    Route::post('/interaction/like', [\App\Http\Controllers\Web\InteractionController::class, 'like'])->name('interaction.like');
    Route::post('/interaction/repost', [\App\Http\Controllers\Web\InteractionController::class, 'repost'])->name('repost.toggle');
    Route::post('/interaction/comment', [\App\Http\Controllers\Web\InteractionController::class, 'comment'])->name('interaction.comment');
    Route::post('/interaction/report', [\App\Http\Controllers\Web\InteractionController::class, 'report'])->name('interaction.report');
    Route::post('/interaction/follow', [\App\Http\Controllers\Web\InteractionController::class, 'follow'])->name('interaction.follow');
    Route::post('/interaction/play', [\App\Http\Controllers\Web\InteractionController::class, 'play'])->name('interaction.play');
});

Route::get('/track/{track}', [TrackController::class, 'show'])->name('track.show');

// Public duration auto-fix — called by browser when audio metadata loads (no auth needed)
Route::post('/api/track/{track}/fix-duration', function (\App\Models\Track $track) {
    $validated = request()->validate(['duration' => 'required|integer|min:1']);
    if (!$track->duration || $track->duration <= 0) {
        $track->update(['duration' => $validated['duration']]);
    }
    return response()->json(['ok' => true]);
});

// Track stats endpoint (uses ID for internal consistency)
Route::get('/api/track/{id}/stats', function ($id) {
    $track = \App\Models\Track::find($id);
    if (!$track) return response()->json(['error' => 'Track not found'], 404);
    
    return response()->json([
        'play_count' => $track->play_count,
        'like_count' => $track->like_count,
        'comment_count' => $track->comments()->count(),
    ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
})->name('api.track.stats');
Route::get('/upload/track', [\App\Http\Controllers\Web\UserTrackController::class, 'create'])->middleware(['auth'])->name('track.create');
Route::post('/upload/track', [\App\Http\Controllers\Web\UserTrackController::class, 'store'])->middleware(['auth'])->name('track.store');
Route::get('/track/{track}/download', [TrackController::class, 'download'])->name('track.download');

// FFmpeg & System Diagnostic Route
// System Rescue Route (Run this once on server to clear all caches)
Route::get('/rescue-server', function() {
    try {
        // Clear application cache
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        // Clear route cache
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        // Clear config cache
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        // Clear view cache
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        
        // Filament specific clear (avoiding filament:optimize-clear which might trigger icons error)
        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            \Illuminate\Support\Facades\Artisan::call('filament:clear-cached-components');
        }

        return "✅ تمام کش‌های سیستم با موفقیت پاکسازی شد. اکنون پنل مدیریت را چک کنید.";
    } catch (\Exception $e) {
        return "❌ خطا در پاکسازی کش: " . $e->getMessage();
    }
});

Route::get('/test-ffmpeg', function() {
    $ffmpeg = env('FFMPEG_PATH', 'ffmpeg');
    $ffprobe = env('FFPROBE_PATH', 'ffprobe');
    
    $results = [
        'ffmpeg_command' => "{$ffmpeg} -version",
        'ffprobe_command' => "{$ffprobe} -version",
        'env_ffmpeg_path' => env('FFMPEG_PATH'),
        'env_ffprobe_path' => env('FFPROBE_PATH'),
        'php_user' => get_current_user(),
        'os' => PHP_OS,
        'shell_exec_enabled' => function_exists('shell_exec'),
        'temp_dir' => sys_get_temp_dir(),
        'is_temp_writable' => is_writable(sys_get_temp_dir()),
    ];

    if ($results['shell_exec_enabled']) {
        $results['ffmpeg_output'] = shell_exec("{$ffmpeg} -version 2>&1");
        $results['ffprobe_output'] = shell_exec("{$ffprobe} -version 2>&1");
    }

    return response()->json($results);
});

// Lightweight pre-check: can the current user still stream today?
Route::get('/stream-limit-check', function () {
    $freeLimit = (int) \App\Models\Setting::get('free_stream_limit', 0);
    if ($freeLimit <= 0) {
        return response()->json(['allowed' => true]);
    }

    $user = auth()->user();
    if ($user && $user->isPremium()) {
        return response()->json(['allowed' => true]);
    }

    $today     = now()->format('Y-m-d');
    $subjectId = $user ? "u{$user->id}" : 'g' . request()->ip();
    $cacheKey  = "free_streams_today:{$subjectId}:{$today}";
    $played    = \Illuminate\Support\Facades\Cache::get($cacheKey, []);
    $count     = count($played);

    return response()->json([
        'allowed'       => $count < $freeLimit,
        'limit'         => $freeLimit,
        'played_today'  => $count,
        'remaining'     => max(0, $freeLimit - $count),
    ]);
});

Route::get('/stream/track/{track}', function (App\Models\Track $track) {
    // Check premium-only access first
    if ($track->is_premium_only) {
        $user = auth()->user();
        if (!$user || !$user->isPremium()) {
            // Allow stream if there is a preview duration (JS enforces cutoff)
            $premiumPreviewSec = (int) \App\Models\Setting::get('premium_preview_seconds', 30);
            if ($premiumPreviewSec <= 0) {
                abort(403, 'این آهنگ مخصوص کاربران پریمیوم است.');
            }
        }
    }

    // Determine if this track requires purchase:
    // 1) Track itself is paid, OR
    // 2) Track belongs to a paid album and has no individual price override
    $album = $track->album_id ? \App\Models\Album::find($track->album_id) : null;
    $trackIsPaid  = $track->is_for_sale && $track->price;
    $albumIsPaid  = $album && $album->is_for_sale && $album->price;
    $trackHasOwnPrice = $track->is_for_sale && $track->price;

    // Effective paid status: track's own price OR album's price (when track has no own price)
    $isPaid = $trackIsPaid || ($albumIsPaid && !$trackHasOwnPrice);

    if ($isPaid) {
        // Preview: allow stream, JS enforces cutoff
        $previewSeconds = $track->preview_seconds ?? 0;
        // For album-priced tracks, also check album's preview_seconds
        if ($previewSeconds === 0 && $albumIsPaid) {
            $previewSeconds = $album->preview_seconds ?? 0;
        }
        $hasPreview = $previewSeconds > 0;

        if (!$hasPreview) {
            $user = auth()->user();
            if (!$user) {
                abort(401);
            }
            $hasPlanAccess = $user->activeSubscription?->plan?->includes_paid_content;
            if (!$hasPlanAccess) {
                $hasPurchased = \App\Models\Sale::where('buyer_id', $user->id)
                    ->where('status', 'completed')
                    ->where(function ($q) use ($track, $album) {
                        $q->where(function ($q2) use ($track) {
                            $q2->where('saleable_type', \App\Models\Track::class)
                               ->where('saleable_id', $track->id);
                        });
                        if ($album) {
                            $q->orWhere(function ($q2) use ($album) {
                                $q2->where('saleable_type', \App\Models\Album::class)
                                   ->where('saleable_id', $album->id);
                            });
                        }
                    })->exists();
                if (!$hasPurchased) {
                    abort(403);
                }
            }
        }
    }

    // ── Free stream daily limit enforcement ──
    $freeLimit = (int) \App\Models\Setting::get('free_stream_limit', 0);
    if ($freeLimit > 0) {
        $streamUser = auth()->user();
        $isFreeUser = !$streamUser || !$streamUser->isPremium();
        if ($isFreeUser) {
            $today     = now()->format('Y-m-d');
            $subjectId = $streamUser ? "u{$streamUser->id}" : 'g' . request()->ip();
            $cacheKey  = "free_streams_today:{$subjectId}:{$today}";
            $played    = \Illuminate\Support\Facades\Cache::get($cacheKey, []);
            $trackKey  = (string) $track->id;

            if (!in_array($trackKey, $played)) {
                if (count($played) >= $freeLimit) {
                    return response()->json([
                        'error'        => 'stream_limit_reached',
                        'limit'        => $freeLimit,
                        'message'      => "سقف پخش رایگان روزانه ({$freeLimit} آهنگ) به پایان رسید.",
                        'upgrade_url'  => '/premium',
                    ], 429);
                }
                $played[] = $trackKey;
                // Cache expires at end of today (minimum 60s to avoid edge-case negatives)
                $secsUntilMidnight = max(60, strtotime('tomorrow') - time());
                \Illuminate\Support\Facades\Cache::put($cacheKey, $played, $secsUntilMidnight);
            }
        }
    }

    $path = $track->getEffectiveStreamPath();
    
    // Check for quality request
    $requestedQuality = request('quality');
    $streamUser = auth()->user();
    $canHighQuality = $streamUser && $streamUser->isPremium()
        && in_array($streamUser->activeSubscription?->plan?->audio_quality, ['high', 'lossless', 'hd']);

    if ($requestedQuality === 'medium' && $track->file_path_128 && file_exists(storage_path('app/public/' . $track->file_path_128))) {
        $path = storage_path('app/public/' . $track->file_path_128);
    } elseif ($requestedQuality === 'high' && $canHighQuality && $track->file_path_320 && file_exists(storage_path('app/public/' . $track->file_path_320))) {
        $path = storage_path('app/public/' . $track->file_path_320);
    }

    if (!$path) {
        abort(404);
    }

    $size = filesize($path);
    $mime = 'audio/mpeg';
    $headers = [
        'Content-Type'  => $mime,
        'Accept-Ranges' => 'bytes',
        'Cache-Control' => 'no-store',
    ];

    $range = request()->header('Range');
    if ($range) {
        preg_match('/bytes=(\d+)-(\d*)/', $range, $matches);
        $start  = intval($matches[1]);
        $end    = isset($matches[2]) && $matches[2] !== '' ? intval($matches[2]) : $size - 1;
        $length = $end - $start + 1;

        $headers['Content-Range']  = "bytes {$start}-{$end}/{$size}";
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
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/album/{album}', [AlbumController::class, 'show'])->name('album.show');

// Admin album track reorder (used by Filament EditAlbum page footer)
Route::middleware(['auth'])->group(function () {
    Route::post('/admin/albums/{album}/reorder-tracks', function (\Illuminate\Http\Request $request, \App\Models\Album $album) {
        abort_if(!auth()->user()->isAdmin(), 403);
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);
        foreach ($request->order as $position => $trackId) {
            $album->tracks()->where('id', $trackId)->update(['track_number' => $position + 1]);
        }
        return response()->json(['ok' => true]);
    })->name('filament.admin.album-track-reorder');

    Route::get('/admin/albums/{album}/search-tracks', function (\Illuminate\Http\Request $request, \App\Models\Album $album) {
        abort_if(!auth()->user()->isAdmin(), 403);
        $q = trim($request->get('q', ''));
        $tracks = \App\Models\Track::where('artist_id', $album->artist_id)
            ->where('album_id', '!=', $album->id)
            ->when($q, fn($query) => $query->where('title', 'like', "%{$q}%"))
            ->orderBy('title')
            ->limit(20)
            ->get(['id', 'title', 'status']);
        return response()->json($tracks);
    })->name('filament.admin.album-track-search');

    Route::post('/admin/albums/{album}/attach-track', function (\Illuminate\Http\Request $request, \App\Models\Album $album) {
        abort_if(!auth()->user()->isAdmin(), 403);
        $request->validate(['track_id' => 'required|integer|exists:tracks,id']);
        $track = \App\Models\Track::findOrFail($request->track_id);
        abort_if($track->artist_id !== $album->artist_id, 422);
        $maxNum = $album->tracks()->max('track_number') ?? 0;
        $track->update(['album_id' => $album->id, 'track_number' => $maxNum + 1]);
        return response()->json(['ok' => true, 'track_number' => $maxNum + 1]);
    })->name('filament.admin.album-track-attach');

    Route::post('/admin/albums/{album}/detach-track', function (\Illuminate\Http\Request $request, \App\Models\Album $album) {
        abort_if(!auth()->user()->isAdmin(), 403);
        $request->validate(['track_id' => 'required|integer|exists:tracks,id']);
        $album->tracks()->where('id', $request->track_id)->update(['album_id' => null, 'track_number' => null]);
        return response()->json(['ok' => true]);
    })->name('filament.admin.album-track-detach');

    Route::post('/admin/backfill-earnings', function () {
        abort_if(!auth()->user()->isAdmin(), 403);
        $settings = \App\Models\EarningsSetting::getSettings();
        if (!$settings->is_enabled || $settings->plays_threshold <= 0) {
            return response()->json(['error' => 'سیستم درآمد فعال نیست'], 422);
        }
        $tracks = \App\Models\Track::whereHas('artist')->with('artist.user')->get();
        $processed = 0; $totalDeposited = 0;
        foreach ($tracks as $track) {
            $artist = $track->artist;
            if (!$artist || $track->play_count < $settings->plays_threshold) continue;
            $milestones  = intdiv($track->play_count, $settings->plays_threshold);
            $totalEarned = $milestones * $settings->earning_amount_toman;
            $existing = \App\Models\ArtistEarning::where('artist_id', $artist->id)
                ->where('playable_id', $track->id)
                ->where('playable_type', \App\Models\Track::class)->first();
            $alreadyPaid = $existing ? $existing->earning_amount_toman : 0;
            $toPay = $totalEarned - $alreadyPaid;
            if ($toPay <= 0) continue;
            $earning = \App\Models\ArtistEarning::updateOrCreate(
                ['artist_id' => $artist->id, 'playable_id' => $track->id, 'playable_type' => \App\Models\Track::class],
                ['play_count' => $track->play_count, 'earning_amount_toman' => $totalEarned, 'status' => 'paid', 'paid_at' => now()]
            );
            if ($artist->user) {
                $wallet = $artist->user->getOrCreateWallet();
                $wallet->deposit($toPay, "درآمد پخش (بازگشتی): آهنگ «{$track->title}» | {$track->play_count} پخش", $earning);
                $totalDeposited += $toPay;
            }
            $processed++;
        }
        return response()->json(['ok' => true, 'processed' => $processed, 'deposited' => $totalDeposited]);
    })->name('admin.backfill-earnings');
});

// Profile routes for all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [\App\Http\Controllers\Web\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Web\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Web\ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// All specific /artist/* routes (must be BEFORE /artist/{artist})
Route::middleware(['auth'])->prefix('artist')->group(function () {
    Route::get('/dashboard',       [\App\Http\Controllers\Artist\DashboardController::class, 'index'])->name('artist.dashboard');
    Route::get('/analytics',       [\App\Http\Controllers\Artist\AnalyticsController::class, 'index'])->name('artist.analytics');
    Route::get('/earnings', fn() => redirect()->route('artist.analytics'))->name('artist.earnings');
    Route::get('/settings',        [\App\Http\Controllers\Artist\SettingsController::class, 'edit'])->name('artist.settings');
    Route::put('/settings',        [\App\Http\Controllers\Artist\SettingsController::class, 'update'])->name('artist.settings.update');

    // Subscription Plans
    Route::get('/plans', [\App\Http\Controllers\Artist\SubscriptionController::class, 'index'])->name('artist.plans');
    Route::get('/plans/checkout/{plan}', [\App\Http\Controllers\Artist\SubscriptionController::class, 'checkout'])->name('artist.subscription.checkout');
    Route::post('/plans/pay', [\App\Http\Controllers\Artist\SubscriptionController::class, 'pay'])->name('artist.subscription.pay');

    // Tracks
    Route::get('/tracks',          [\App\Http\Controllers\Artist\TrackController::class, 'index'])->name('artist.tracks');
    Route::get('/tracks/create',   [\App\Http\Controllers\Artist\TrackController::class, 'create'])->name('artist.tracks.create');
    Route::post('/tracks',         [\App\Http\Controllers\Artist\TrackController::class, 'store'])->name('artist.tracks.store');
    Route::get('/tracks/{track}/edit',   [\App\Http\Controllers\Artist\TrackController::class, 'edit'])->name('artist.tracks.edit');
    Route::put('/tracks/{track}',        [\App\Http\Controllers\Artist\TrackController::class, 'update'])->name('artist.tracks.update');
    Route::delete('/tracks/{track}',     [\App\Http\Controllers\Artist\TrackController::class, 'destroy'])->name('artist.tracks.destroy');

    // Albums
    Route::get('/albums',          [\App\Http\Controllers\Artist\AlbumController::class, 'index'])->name('artist.albums');
    Route::get('/albums/create',   [\App\Http\Controllers\Artist\AlbumController::class, 'create'])->name('artist.albums.create');
    Route::post('/albums',         [\App\Http\Controllers\Artist\AlbumController::class, 'store'])->name('artist.albums.store');
    Route::get('/albums/{album}/edit',   [\App\Http\Controllers\Artist\AlbumController::class, 'edit'])->name('artist.albums.edit');
    Route::put('/albums/{album}',        [\App\Http\Controllers\Artist\AlbumController::class, 'update'])->name('artist.albums.update');
    Route::delete('/albums/{album}',     [\App\Http\Controllers\Artist\AlbumController::class, 'destroy'])->name('artist.albums.destroy');
    Route::post('/albums/{album}/reorder', [\App\Http\Controllers\Artist\AlbumController::class, 'reorderTracks'])->name('artist.albums.reorder');

    // Podcasts
    Route::get('/podcasts', [\App\Http\Controllers\Artist\PodcastController::class, 'index'])->name('artist.podcasts.index');
    Route::get('/podcasts/create', [\App\Http\Controllers\Artist\PodcastController::class, 'create'])->name('artist.podcasts.create');
    Route::post('/podcasts', [\App\Http\Controllers\Artist\PodcastController::class, 'store'])->name('artist.podcasts.store');
    Route::get('/podcasts/{podcast}/edit', [\App\Http\Controllers\Artist\PodcastController::class, 'edit'])->name('artist.podcasts.edit');
    Route::put('/podcasts/{podcast}', [\App\Http\Controllers\Artist\PodcastController::class, 'update'])->name('artist.podcasts.update');
    Route::delete('/podcasts/{podcast}', [\App\Http\Controllers\Artist\PodcastController::class, 'destroy'])->name('artist.podcasts.destroy');

    // Podcast Episodes
    Route::get('/podcasts/{podcast}/episodes', [\App\Http\Controllers\Artist\PodcastController::class, 'episodesIndex'])->name('artist.podcasts.episodes.index');
    Route::get('/podcasts/{podcast}/episodes/create', [\App\Http\Controllers\Artist\PodcastController::class, 'episodesCreate'])->name('artist.podcasts.episodes.create');
    Route::post('/podcasts/{podcast}/episodes', [\App\Http\Controllers\Artist\PodcastController::class, 'episodesStore'])->name('artist.podcasts.episodes.store');
    Route::get('/podcasts/{podcast}/episodes/{episode}/edit', [\App\Http\Controllers\Artist\PodcastController::class, 'episodesEdit'])->name('artist.podcasts.episodes.edit');
    Route::put('/podcasts/{podcast}/episodes/{episode}', [\App\Http\Controllers\Artist\PodcastController::class, 'episodesUpdate'])->name('artist.podcasts.episodes.update');
    Route::delete('/podcasts/{podcast}/episodes/{episode}', [\App\Http\Controllers\Artist\PodcastController::class, 'episodesDestroy'])->name('artist.podcasts.episodes.destroy');
});

// DEBUG: Artist dashboard test
Route::get('/artist-dashboard-test', function () {
    return 'Artist Dashboard Route Works!';
});

Route::get('/artist/{artist}', [ArtistController::class, 'show'])->name('artist.show');
Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
Route::get('/playlist/{playlist}', [PlaylistController::class, 'show'])->name('playlist.show');
Route::middleware('auth')->group(function () {
    // Move static routes above dynamic ones to avoid 404
    Route::post('/playlist/add-track', function () {
        $validated = request()->validate([
            'playlist_id' => 'required|integer',
            'track_id' => 'required|integer|exists:tracks,id',
        ]);

        $playlist = auth()->user()->playlists()->findOrFail($validated['playlist_id']);

        if ($playlist->is_auto_generated || $playlist->is_system) {
            return response()->json(['added' => false, 'error' => 'شما نمی‌توانید آهنگ به پلی‌لیست‌های سیستمی اضافه کنید.'], 403);
        }

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
    })->name('playlist.create.json');

    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlist.create');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlist.store');
    Route::get('/playlist/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
    Route::post('/playlist/{playlist}', [PlaylistController::class, 'update'])->name('playlist.update');
    Route::delete('/playlist/{playlist}', [PlaylistController::class, 'destroy'])->name('playlist.destroy');
});
Route::get('/podcasts', [PodcastController::class, 'index'])->name('podcasts.index');
Route::get('/podcast/{podcast}', [PodcastController::class, 'show'])->name('podcast.show');
Route::post('/podcast/{podcast}/subscribe', [PodcastController::class, 'toggleSubscription'])->name('podcast.subscribe');
Route::get('/podcast/episode/{episode}/download', [PodcastController::class, 'downloadEpisode'])->name('podcast.episode.download');

// Podcast Episode stream
Route::get('/stream/episode/{episode}', function (App\Models\PodcastEpisode $episode) {
    // Check if the episode is premium-only
    if ($episode->is_premium_only) {
        $user = auth()->user();
        if (!$user || !$user->isPremium()) {
            // Allow stream if there is a preview duration (JS enforces cutoff)
            $premiumPreviewSec = (int) \App\Models\Setting::get('premium_preview_seconds', 30);
            if ($premiumPreviewSec <= 0) {
                abort(403, 'این قسمت مخصوص کاربران پریمیوم است.');
            }
        }
    }

    $path = $episode->getEffectiveStreamPath();
    if (!$path) {
        abort(404);
    }

    $size = filesize($path);
    $mime = 'audio/mpeg';
    $headers = [
        'Content-Type'  => $mime,
        'Accept-Ranges' => 'bytes',
        'Cache-Control' => 'no-store',
    ];

    $range = request()->header('Range');
    if ($range) {
        preg_match('/bytes=(\d+)-(\d*)/', $range, $matches);
        $start  = intval($matches[1]);
        $end    = isset($matches[2]) && $matches[2] !== '' ? intval($matches[2]) : $size - 1;
        $length = $end - $start + 1;

        $headers['Content-Range']  = "bytes {$start}-{$end}/{$size}";
        $headers['Content-Length'] = $length;

        $file = fopen($path, 'rb');
        fseek($file, $start);
        $data = fread($file, $length);
        fclose($file);

        return response($data, 206, $headers);
    }

    $headers['Content-Length'] = $size;
    return response()->file($path, $headers);
})->name('podcast.episode.stream');

Route::get('/premium', [SubscriptionController::class, 'plans'])->name('premium');
Route::get('/p/{page:slug}', [PageController::class, 'show'])->name('page.show');

// ── Auth Routes ──
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

// Verify Account (OTP)
Route::get('/verify-account', \App\Livewire\VerifyAccount::class)->middleware('auth')->name('verify-account');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    if (request()->expectsJson()) {
        return response()->json(['success' => true]);
    }
    return redirect('/?_=' . time());
})->middleware('auth')->name('logout');

// Auth state check (used by SPA navigation to detect logout)
Route::get('/auth/state', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'is_artist'     => auth()->check() && auth()->user()?->isArtist(),
    ]);
})->name('auth.state');

// ── Authenticated Routes ──
Route::middleware('auth')->group(function () {
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::get('/library/liked', [LibraryController::class, 'liked'])->name('library.liked');
    Route::get('/library/playlists', [LibraryController::class, 'playlists'])->name('library.playlists');
    Route::get('/library/history', [LibraryController::class, 'history'])->name('library.history');
    Route::get('/library/albums', [LibraryController::class, 'albums'])->name('library.albums');
    Route::get('/library/artists', [LibraryController::class, 'artists'])->name('library.artists');
    Route::get('/library/podcasts', [LibraryController::class, 'podcasts'])->name('library.podcasts');
    Route::get('/library/downloads', [LibraryController::class, 'downloads'])->name('library.downloads');
    Route::post('/library/validate-coupon', [LibraryController::class, 'validateCoupon'])->name('coupon.validate');

    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::post('/wallet/deposit', [WalletController::class, 'depositRequest'])->name('wallet.deposit');
    Route::post('/wallet/deposit-online', [WalletController::class, 'gatewayDeposit'])->name('wallet.deposit.online');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdrawRequest'])->name('wallet.withdraw');
    Route::get('/purchase', [PurchaseController::class, 'confirm'])->name('purchase');
    Route::post('/purchase', [PurchaseController::class, 'purchase'])->name('purchase.submit');
    Route::get('/my-purchases', [PurchaseController::class, 'userPurchases'])->name('purchases');
    Route::get('/discover', [LibraryController::class, 'discover'])->name('discover');
    Route::get('/profile', [LibraryController::class, 'profile'])->name('profile');
    Route::get('/user/{user}', [LibraryController::class, 'publicProfile'])->name('user.public_profile');
    Route::get('/settings', [LibraryController::class, 'settings'])->name('settings');
    Route::get('/my-reports', [LibraryController::class, 'myReports'])->name('my.reports');
    Route::get('/become-artist', [\App\Http\Controllers\Web\ArtistApplicationController::class, 'show'])->name('artist-application.show');
    Route::post('/become-artist', [\App\Http\Controllers\Web\ArtistApplicationController::class, 'store'])->name('artist-application.store');

    // Track duration update (auto-fix for missing durations)
    Route::post('/api/tracks/{track}/update-duration', function (\App\Models\Track $track) {
        $validated = request()->validate(['duration' => 'required|integer|min:1']);
        if (!$track->duration || $track->duration <= 0) {
            $track->update(['duration' => $validated['duration']]);
        }
        return response()->json(['success' => true]);
    })->name('tracks.update-duration');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Stream recording (web version - session auth)
    Route::post('/stream/record', function (App\Services\StreamService $streamService) {
        request()->validate([
            'track_id' => 'nullable|exists:tracks,id',
            'episode_id' => 'nullable|exists:podcast_episodes,id',
            'duration_listened' => 'required|integer|min:0',
            'completed' => 'boolean',
        ]);

        if (request('episode_id')) {
            $episode = \App\Models\PodcastEpisode::findOrFail(request('episode_id'));
            $streamService->recordEpisodeStream(auth()->user(), $episode, [
                'duration_listened' => request('duration_listened'),
                'completed' => request('completed', false),
            ]);
            $streamService->addToRecentlyPlayed(auth()->user(), $episode, request('duration_listened'));
        } else if (request('track_id')) {
            $track = \App\Models\Track::findOrFail(request('track_id'));
            $streamService->recordStream(auth()->user(), $track, [
                'duration_listened' => request('duration_listened'),
                'completed' => request('completed', false),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'device_type' => 'web',
            ]);
            $streamService->addToRecentlyPlayed(auth()->user(), $track, request('duration_listened'));
        }

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

    // Repost track

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
    Route::post('/like/toggle', [\App\Http\Controllers\Web\InteractionController::class, 'like'])->name('like.toggle');

    // Report (شکایت)
    Route::post('/report', [\App\Http\Controllers\Web\ReportController::class, 'store'])->name('report.store');

    // Follow toggle
    Route::post('/follow/toggle', [\App\Http\Controllers\Web\InteractionController::class, 'follow'])->name('follow.toggle');

    // Subscription
    Route::get('/subscription/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('/subscription/pay', [SubscriptionController::class, 'pay'])->name('subscription.pay');
    Route::get('/payment/verify', [\App\Http\Controllers\Web\PaymentController::class, 'verify'])->name('payment.verify');
    Route::post('/payment/verify', [\App\Http\Controllers\Web\PaymentController::class, 'verify']);
});


// DEBUG: Simple artist dashboard test
Route::get('/artist-dash-test2', function () {
    if (!auth()->check()) {
        return 'Not logged in';
    }
    if (!auth()->user()->isArtist()) {
        return 'Not an artist. Type: ' . auth()->user()->type;
    }
    return 'Artist OK: ' . auth()->user()->name;
})->middleware('auth');
