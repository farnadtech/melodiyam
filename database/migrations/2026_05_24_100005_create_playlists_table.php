<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('visibility', ['public', 'private', 'collaborative'])->default('private');
            $table->boolean('is_system')->default(false); // liked songs, etc.
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_sponsored')->default(false);
            $table->unsignedBigInteger('followers_count')->default(0);
            $table->unsignedInteger('tracks_count')->default(0);
            $table->unsignedBigInteger('total_duration')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('visibility');
            $table->index('is_featured');
        });

        Schema::create('playlist_track', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('track_id')->constrained()->cascadeOnDelete();
            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->unique(['playlist_id', 'track_id']);
            $table->index('position');
        });

        Schema::create('playlist_followers', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('playlist_id')->constrained()->cascadeOnDelete();
            $table->primary(['user_id', 'playlist_id']);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('playlist_followers');
        Schema::dropIfExists('playlist_track');
        Schema::dropIfExists('playlists');
    }
};
