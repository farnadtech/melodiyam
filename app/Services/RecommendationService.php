<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Playlist;
use App\Models\Stream;
use App\Models\Track;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    /**
     * Main entry point — returns cached personalized recommendations.
     */
    public function getRecommendations(User $user, int $trackLimit = 20, int $albumLimit = 12, int $playlistLimit = 8): array
    {
        $cacheKey = "discover.rec.{$user->id}";
        $cacheTtl = 7 * 24 * 60 * 60; // 7 days

        return Cache::remember($cacheKey, $cacheTtl, function () use ($user, $trackLimit, $albumLimit, $playlistLimit) {
            return $this->buildRecommendations($user, $trackLimit, $albumLimit, $playlistLimit);
        });
    }

    /**
     * Build full recommendation payload.
     */
    protected function buildRecommendations(User $user, int $trackLimit, int $albumLimit, int $playlistLimit): array
    {
        $profile = $this->buildTasteProfile($user);
        $isPersonalized = !empty($profile['genres']) || !empty($profile['artists']);

        // Always include trending for everyone
        $trendingTracks = $this->getTrendingFallback(20);

        if (!$isPersonalized) {
            return [
                'recommendedTracks' => collect($trendingTracks),
                'recommendedAlbums' => $this->getTrendingAlbums($albumLimit),
                'recommendedPlaylists' => $this->getTrendingPlaylists($playlistLimit),
                'trendingTracks' => collect($trendingTracks),
                'tasteProfile' => $profile,
                'isPersonalized' => false,
                'generatedAt' => now(),
            ];
        }

        return [
            'recommendedTracks' => $this->scoreTracks($user, $profile, $trackLimit),
            'recommendedAlbums' => $this->getRecommendedAlbums($user, $profile, $albumLimit),
            'recommendedPlaylists' => $this->getRecommendedPlaylists($user, $profile, $playlistLimit),
            'trendingTracks' => collect($trendingTracks),
            'tasteProfile' => $profile,
            'isPersonalized' => true,
            'generatedAt' => now(),
        ];
    }

    /**
     * Analyze user's listening behavior to build a taste profile.
     * Returns top genres, artists, moods, and listened track IDs.
     */
    public function buildTasteProfile(User $user): array
    {
        // 1. Get tracks the user has streamed (last 90 days), weighted by play count
        $streamedTrackIds = Stream::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(90))
            ->pluck('track_id')
            ->unique()
            ->toArray();

        // 2. Get tracks the user has liked
        $likedTrackIds = Like::where('user_id', $user->id)
            ->where('likeable_type', Track::class)
            ->pluck('likeable_id')
            ->toArray();

        // 3. Get albums the user has liked
        $likedAlbumIds = Like::where('user_id', $user->id)
            ->where('likeable_type', Album::class)
            ->pluck('likeable_id')
            ->toArray();

        // All known track IDs (for exclusion later)
        $allKnownTrackIds = array_unique(array_merge($streamedTrackIds, $likedTrackIds));

        // 4. Score genres from streams + likes
        $genreScores = [];
        $allTrackIds = array_unique(array_merge($streamedTrackIds, $likedTrackIds));

        if (!empty($allTrackIds)) {
            // Get genre_id from tracks (primary genre)
            $primaryGenres = Track::whereIn('id', $allTrackIds)
                ->whereNotNull('genre_id')
                ->select('genre_id', DB::raw('COUNT(*) as cnt'))
                ->groupBy('genre_id')
                ->pluck('cnt', 'genre_id')
                ->toArray();

            foreach ($primaryGenres as $genreId => $count) {
                $genreScores[$genreId] = ($genreScores[$genreId] ?? 0) + $count * 2;
            }

            // Get genres from many-to-many relationship
            $manyToManyGenres = DB::table('genre_track')
                ->whereIn('track_id', $allTrackIds)
                ->select('genre_id', DB::raw('COUNT(*) as cnt'))
                ->groupBy('genre_id')
                ->pluck('cnt', 'genre_id')
                ->toArray();

            foreach ($manyToManyGenres as $genreId => $count) {
                $genreScores[$genreId] = ($genreScores[$genreId] ?? 0) + $count;
            }
        }

        // Also weight genres from liked albums
        if (!empty($likedAlbumIds)) {
            $albumGenres = Album::whereIn('id', $likedAlbumIds)
                ->whereNotNull('genre_id')
                ->select('genre_id', DB::raw('COUNT(*) as cnt'))
                ->groupBy('genre_id')
                ->pluck('cnt', 'genre_id')
                ->toArray();

            foreach ($albumGenres as $genreId => $count) {
                $genreScores[$genreId] = ($genreScores[$genreId] ?? 0) + $count * 3;
            }
        }

        arsort($genreScores);
        $topGenres = array_slice($genreScores, 0, 8, true);

        // 5. Score artists from streams + follows
        $artistScores = [];

        if (!empty($allTrackIds)) {
            $artistCounts = Track::whereIn('id', $allTrackIds)
                ->whereNotNull('artist_id')
                ->select('artist_id', DB::raw('COUNT(*) as cnt'))
                ->groupBy('artist_id')
                ->pluck('cnt', 'artist_id')
                ->toArray();

            foreach ($artistCounts as $artistId => $count) {
                $artistScores[$artistId] = ($artistScores[$artistId] ?? 0) + $count * 2;
            }
        }

        // Boost followed artists
        $followedArtistIds = Follow::where('user_id', $user->id)
            ->where('followable_type', Artist::class)
            ->pluck('followable_id')
            ->toArray();

        foreach ($followedArtistIds as $artistId) {
            $artistScores[$artistId] = ($artistScores[$artistId] ?? 0) + 10;
        }

        arsort($artistScores);
        $topArtists = array_slice($artistScores, 0, 10, true);

        // 6. Score moods from streamed/liked tracks
        $moodScores = [];
        if (!empty($allTrackIds)) {
            $moodCounts = Track::whereIn('id', $allTrackIds)
                ->whereNotNull('mood')
                ->where('mood', '!=', '')
                ->select('mood', DB::raw('COUNT(*) as cnt'))
                ->groupBy('mood')
                ->pluck('cnt', 'mood')
                ->toArray();

            foreach ($moodCounts as $mood => $count) {
                $moodScores[$mood] = $count;
            }
        }

        arsort($moodScores);
        $topMoods = array_slice($moodScores, 0, 5, true);

        // 7. Get genre/artist names for display
        $genreNames = [];
        if (!empty($topGenres)) {
            $genreNames = \App\Models\Genre::whereIn('id', array_keys($topGenres))
                ->pluck('name', 'id')
                ->toArray();
        }

        $artistNames = [];
        if (!empty($topArtists)) {
            $artistNames = Artist::whereIn('id', array_keys($topArtists))
                ->pluck('display_name', 'id')
                ->toArray();
        }

        return [
            'genres' => $topGenres,
            'artists' => $topArtists,
            'moods' => $topMoods,
            'listened_track_ids' => $allKnownTrackIds,
            'followed_artist_ids' => $followedArtistIds,
            'genre_names' => $genreNames,
            'artist_names' => $artistNames,
        ];
    }

    /**
     * Score and rank tracks based on the user's taste profile.
     */
    public function scoreTracks(User $user, array $profile, int $limit = 20): \Illuminate\Support\Collection
    {
        $excludeIds = $profile['listened_track_ids'] ?? [];
        $topGenres = $profile['genres'] ?? [];
        $topArtists = $profile['artists'] ?? [];
        $topMoods = $profile['moods'] ?? [];

        // Fetch candidate tracks (published, not already listened to)
        $query = Track::published()
            ->with(['artist', 'album'])
            ->whereNotIn('id', $excludeIds);

        // Narrow by relevant genres/artists for efficiency
        $genreIds = array_keys($topGenres);
        $artistIds = array_keys($topArtists);

        if (!empty($genreIds) || !empty($artistIds)) {
            $query->where(function ($q) use ($genreIds, $artistIds) {
                if (!empty($genreIds)) {
                    $q->whereIn('genre_id', $genreIds)
                      ->orWhereHas('genres', fn($gq) => $gq->whereIn('genres.id', $genreIds));
                }
                if (!empty($artistIds)) {
                    $q->orWhereIn('artist_id', $artistIds);
                }
            });
        }

        $candidates = $query->with('genres')->limit(200)->get();

        // Score each candidate
        $genreNames = $profile['genre_names'] ?? [];
        $scored = $candidates->map(function (Track $track) use ($topGenres, $topArtists, $topMoods, $genreNames, $profile) {
            $score = 0;
            $reason = '';

            // Genre match (primary)
            if ($track->genre_id && isset($topGenres[$track->genre_id])) {
                $score += 3;
                $reason = 'genre';
            }

            // Genre match (many-to-many) — check if track has any matching genre
            $trackGenreIds = $track->genres->pluck('id')->toArray();
            foreach ($trackGenreIds as $gId) {
                if (isset($topGenres[$gId])) {
                    $score += 2;
                    if (!$reason) $reason = 'genre';
                    break;
                }
            }

            // Artist match
            if ($track->artist_id && isset($topArtists[$track->artist_id])) {
                $score += 4;
                $reason = 'artist';
            }

            // Mood match
            if ($track->mood && isset($topMoods[$track->mood])) {
                $score += 2;
                if (!$reason) $reason = 'mood';
            }

            // Popularity bonus (max +3)
            $score += min(3, intdiv($track->play_count ?? 0, 100));

            // Recency bonus
            if ($track->published_at && $track->published_at->gt(now()->subDays(30))) {
                $score += 2;
            }

            // Randomness factor (0-2)
            $score += random_int(0, 2);

            // Build reason label
            $reasonLabel = '';
            if ($reason === 'artist' && $track->artist) {
                $reasonLabel = 'چون ' . $track->artist->display_name . ' گوش دادی';
            } elseif ($reason === 'genre' && $track->genre_id && isset($genreNames[$track->genre_id])) {
                $reasonLabel = 'علاقه‌مند به ' . $genreNames[$track->genre_id];
            } elseif ($reason === 'mood' && $track->mood) {
                $reasonLabel = 'حس و حال ' . $track->mood;
            }

            return [
                'track' => $track,
                'score' => $score,
                'reason' => $reasonLabel,
            ];
        });

        return $scored->sortByDesc('score')->take($limit)->values();
    }

    /**
     * Get recommended albums based on taste profile.
     */
    public function getRecommendedAlbums(User $user, array $profile, int $limit = 12): \Illuminate\Support\Collection
    {
        $topGenres = array_keys($profile['genres'] ?? []);
        $topArtists = array_keys($profile['artists'] ?? []);

        // Exclude albums user already interacted with (via streamed tracks)
        $streamedAlbumIds = Stream::where('streams.user_id', $user->id)
            ->join('tracks', 'streams.track_id', '=', 'tracks.id')
            ->whereNotNull('tracks.album_id')
            ->pluck('tracks.album_id')
            ->unique()
            ->toArray();

        $query = Album::published()
            ->with(['artist'])
            ->withCount('tracks')
            ->whereNotIn('id', $streamedAlbumIds);

        if (!empty($topGenres) || !empty($topArtists)) {
            $query->where(function ($q) use ($topGenres, $topArtists) {
                if (!empty($topGenres)) {
                    $q->whereIn('genre_id', $topGenres);
                }
                if (!empty($topArtists)) {
                    $q->orWhereIn('artist_id', $topArtists);
                }
            });
        }

        return $query->orderByDesc('play_count')
            ->limit($limit)
            ->get()
            ->map(function (Album $album) use ($profile) {
                $reason = '';
                if ($album->artist_id && isset($profile['artists'][$album->artist_id])) {
                    $reason = 'هنرمند مورد علاقه: ' . ($album->artist->display_name ?? '');
                } elseif ($album->genre_id && isset($profile['genre_names'][$album->genre_id])) {
                    $reason = 'ژانر مورد علاقه: ' . $profile['genre_names'][$album->genre_id];
                }
                return [
                    'album' => $album,
                    'reason' => $reason,
                ];
            });
    }

    /**
     * Get recommended playlists based on taste profile.
     */
    public function getRecommendedPlaylists(User $user, array $profile, int $limit = 8): \Illuminate\Support\Collection
    {
        $topGenres = array_keys($profile['genres'] ?? []);
        $topArtists = array_keys($profile['artists'] ?? []);
        $topTrackIds = $profile['listened_track_ids'] ?? [];

        // Find playlists that contain tracks matching user's taste
        $matchingPlaylistIds = DB::table('playlist_track')
            ->join('tracks', 'playlist_track.track_id', '=', 'tracks.id')
            ->where(function ($q) use ($topGenres, $topArtists) {
                if (!empty($topGenres)) {
                    $q->whereIn('tracks.genre_id', $topGenres);
                }
                if (!empty($topArtists)) {
                    $q->orWhereIn('tracks.artist_id', $topArtists);
                }
            })
            ->groupBy('playlist_track.playlist_id')
            ->select('playlist_track.playlist_id', DB::raw('COUNT(*) as match_count'))
            ->orderByDesc('match_count')
            ->limit($limit * 3) // Get more candidates than needed
            ->pluck('playlist_id')
            ->toArray();

        if (empty($matchingPlaylistIds)) {
            return $this->getTrendingPlaylists($limit);
        }

        return Playlist::whereIn('id', $matchingPlaylistIds)
            ->where('visibility', 'public')
            ->with('user')
            ->withCount('tracks')
            ->orderByDesc('followers_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Fallback: trending tracks for new users with no history.
     */
    public function getTrendingFallback(int $limit = 20): \Illuminate\Support\Collection
    {
        return Track::published()
            ->with(['artist', 'album'])
            ->orderByDesc('play_count')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(function (Track $track) {
                return [
                    'track' => $track,
                    'score' => 0,
                    'reason' => 'پرطرفدار',
                ];
            });
    }

    /**
     * Trending albums fallback.
     */
    protected function getTrendingAlbums(int $limit = 12): \Illuminate\Support\Collection
    {
        return Album::published()
            ->with('artist')
            ->withCount('tracks')
            ->orderByDesc('play_count')
            ->limit($limit)
            ->get()
            ->map(function (Album $album) {
                return [
                    'album' => $album,
                    'reason' => 'پرطرفدار',
                ];
            });
    }

    /**
     * Trending playlists fallback.
     */
    protected function getTrendingPlaylists(int $limit = 8): \Illuminate\Support\Collection
    {
        return Playlist::where('visibility', 'public')
            ->with('user')
            ->withCount('tracks')
            ->orderByDesc('followers_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Invalidate cached recommendations for a user.
     */
    public static function invalidateCache(User $user): void
    {
        Cache::forget("discover.rec.{$user->id}");
    }
}
