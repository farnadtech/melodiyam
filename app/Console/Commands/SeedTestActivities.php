<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Artist;
use App\Models\Track;
use App\Models\Album;
use App\Models\Repost;
use App\Models\User;
use Illuminate\Console\Command;

class SeedTestActivities extends Command
{
    protected $signature = 'seed:test-activities';
    protected $description = 'Seed some test activities for artists and users';

    public function handle()
    {
        $this->info('Seeding test activities...');

        $artists = Artist::all();
        $users = User::where('id', '!=', 1)->take(5)->get(); // Get some regular users

        if ($artists->isEmpty()) {
            $this->error('No artists found in database!');
            return;
        }

        foreach ($artists as $artist) {
            if (!$artist->user_id) continue;

            // 1. New Track Activities
            $tracks = Track::where('artist_id', $artist->id)->take(2)->get();
            foreach ($tracks as $track) {
                Activity::updateOrCreate([
                    'user_id' => $artist->user_id,
                    'type' => 'track_published',
                    'subject_id' => $track->id,
                    'subject_type' => Track::class,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }

            // 2. New Album Activities
            $albums = Album::where('artist_id', $artist->id)->take(1)->get();
            foreach ($albums as $album) {
                Activity::updateOrCreate([
                    'user_id' => $artist->user_id,
                    'type' => 'album_published',
                    'subject_id' => $album->id,
                    'subject_type' => Album::class,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        // 3. Repost Activities by Users
        foreach ($users as $user) {
            $randomTrack = Track::inRandomOrder()->first();
            if ($randomTrack) {
                $repost = Repost::updateOrCreate([
                    'user_id' => $user->id,
                    'repostable_id' => $randomTrack->id,
                    'repostable_type' => Track::class,
                ]);

                Activity::updateOrCreate([
                    'user_id' => $user->id,
                    'type' => 'reposted',
                    'subject_id' => $repost->id,
                    'subject_type' => Repost::class,
                    'created_at' => now()->subDays(rand(1, 5)),
                ]);
            }
        }

        $this->info('Done! Test activities seeded successfully.');
    }
}
