<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE homepage_sections MODIFY COLUMN type ENUM(
            'slider','featured_playlists','featured_artists',
            'new_releases','trending','genres','podcasts',
            'recommended','custom','banner','recently_played',
            'hero','latest_albums','top_charts','artist_spotlight',
            'custom_tracks','featured_track'
        ) NOT NULL DEFAULT 'custom'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE homepage_sections MODIFY COLUMN type ENUM(
            'slider','featured_playlists','featured_artists',
            'new_releases','trending','genres','podcasts',
            'recommended','custom','banner','recently_played',
            'hero','latest_albums','top_charts','artist_spotlight','custom_tracks'
        ) NOT NULL DEFAULT 'custom'");
    }
};
