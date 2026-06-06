<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->json('waveform')->nullable()->after('duration');
        });

        Schema::table('podcast_episodes', function (Blueprint $table) {
            $table->json('waveform')->nullable()->after('duration');
        });
    }

    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('waveform');
        });

        Schema::table('podcast_episodes', function (Blueprint $table) {
            $table->dropColumn('waveform');
        });
    }
};
