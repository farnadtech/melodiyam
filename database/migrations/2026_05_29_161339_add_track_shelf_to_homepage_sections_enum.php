<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('homepage_sections', function (Blueprint $table) {
            $table->enum('type', [
                'hero', 'slider', 'featured_playlists', 'featured_artists',
                'new_releases', 'trending', 'genres', 'podcasts',
                'recommended', 'custom', 'banner', 'recently_played',
                'top_charts', 'artist_spotlight', 'latest_albums',
                'custom_tracks', 'featured_track', 'track_shelf'
            ])->change();
        });
    }

    public function down(): void
    {
        Schema::table('homepage_sections', function (Blueprint $table) {
            $table->enum('type', [
                'hero', 'slider', 'featured_playlists', 'featured_artists',
                'new_releases', 'trending', 'genres', 'podcasts',
                'recommended', 'custom', 'banner', 'recently_played',
                'top_charts', 'artist_spotlight', 'latest_albums',
                'custom_tracks', 'featured_track'
            ])->change();
        });
    }
};
