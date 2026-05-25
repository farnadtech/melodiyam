<?php

namespace App\Services;

use App\Models\Stream;
use App\Models\Track;
use App\Models\User;

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
        if (($metadata['duration_listened'] ?? 0) >= $minDuration) {
            $track->increment('play_count');

            if ($track->album_id) {
                $track->album->increment('play_count');
            }

            if ($track->artist) {
                $track->artist->increment('total_streams');
            }
        }

        return $stream;
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
