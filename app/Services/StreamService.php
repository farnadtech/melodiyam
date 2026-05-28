<?php

namespace App\Services;

use App\Models\ArtistEarning;
use App\Models\EarningsSetting;
use App\Models\Stream;
use App\Models\Track;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class StreamService
{
    public function recordStream(User $user, Track $track, array $metadata = []): Stream
    {
        $stream = Stream::create([
            'user_id' => $user->id,
            'track_id' => $track->id,
            'duration_listened' => $metadata['duration_listened'] ?? 0,
            'completed' => $metadata['completed'] ?? false,
            'ip_address' => $metadata['ip_address'] ?? request()->ip(),
            'user_agent' => $metadata['user_agent'] ?? request()->userAgent(),
            'country' => $metadata['country'] ?? 'IR',
            'device_type' => $metadata['device_type'] ?? 'web',
        ]);

        // Increment play count only for significant plays (>30s or >50% of track)
        $minDuration = min(30, $track->duration * 0.5);
        if (($metadata['duration_listened'] ?? 0) >= $minDuration && $this->canCountPlay($user, $track)) {
            $track->increment('play_count');

            if ($track->album_id) {
                $track->album->increment('play_count');
            }

            if ($track->artist) {
                $track->artist->increment('total_streams');
                $this->maybeCreateEarning($track);
            }
        }

        return $stream;
    }

    private function canCountPlay(User $user, Track $track): bool
    {
        // Cooldown = max(track duration, 60s) so skipping/refreshing can't inflate count
        $cooldown = max((int) ($track->duration ?? 60), 60);
        $key = "play_counted:{$user->id}:{$track->id}";

        if (Cache::has($key)) {
            return false;
        }

        Cache::put($key, 1, $cooldown);
        return true;
    }

    private function maybeCreateEarning(Track $track): void
    {
        $settings = EarningsSetting::getSettings();
        if (!$settings->is_enabled || $settings->plays_threshold <= 0) {
            return;
        }

        $artist = $track->artist;
        // Refresh from DB to get the updated play_count after increment()
        $currentPlays = $track->fresh()->play_count;

        // Only act when we cross a new milestone
        if ($currentPlays % $settings->plays_threshold !== 0) {
            return;
        }

        // One aggregate record per (artist, track) — update total milestones reached
        $totalMilestones = intdiv($currentPlays, $settings->plays_threshold);
        $totalEarned     = $totalMilestones * $settings->earning_amount_toman;

        $earning = ArtistEarning::updateOrCreate(
            [
                'artist_id'    => $artist->id,
                'playable_id'  => $track->id,
                'playable_type'=> Track::class,
            ],
            [
                'play_count'           => $currentPlays,
                'earning_amount_toman' => $totalEarned,
                'status'               => 'paid',
                'paid_at'              => now(),
            ]
        );

        // Deposit only the NEW milestone increment (not the full total again)
        $artistUser = $artist->user;
        if ($artistUser) {
            $wallet = $artistUser->getOrCreateWallet();
            $wallet->deposit(
                $settings->earning_amount_toman,
                "درآمد پخش: {$currentPlays} پخش آهنگ «{$track->title}»",
                $earning
            );
        }
    }

    public function addToRecentlyPlayed(User $user, $playable, int $progress = 0): void
    {
        $user->recentlyPlayed()->updateOrCreate(
            [
                'playable_type' => get_class($playable),
                'playable_id' => $playable->id,
            ],
            [
                'progress' => $progress,
                'played_at' => now(),
            ]
        );
    }
}
