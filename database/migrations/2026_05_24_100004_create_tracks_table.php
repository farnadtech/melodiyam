<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('album_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('genre_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedInteger('duration')->default(0); // seconds
            $table->unsignedSmallInteger('track_number')->nullable();
            $table->unsignedSmallInteger('disc_number')->default(1);
            $table->string('file_path')->nullable();
            $table->string('file_path_128')->nullable();
            $table->string('file_path_320')->nullable();
            $table->string('file_url')->nullable(); // external URL
            $table->text('lyrics')->nullable();
            $table->json('synced_lyrics')->nullable();
            $table->string('language', 5)->default('fa');
            $table->boolean('is_explicit')->default(false);
            $table->boolean('is_downloadable')->default(false);
            $table->boolean('is_premium_only')->default(false);
            $table->enum('status', ['draft', 'scheduled', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->date('release_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('play_count')->default(0);
            $table->unsignedBigInteger('like_count')->default(0);
            $table->unsignedBigInteger('download_count')->default(0);
            $table->unsignedBigInteger('share_count')->default(0);
            $table->string('mood')->nullable();
            $table->string('bpm')->nullable();
            $table->string('key_signature')->nullable();
            $table->string('isrc')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('release_date');
            $table->index('is_featured');
            $table->index('play_count');
            $table->index('like_count');
            $table->index('language');
            $table->fullText(['title', 'title_en']);
        });

        // Featuring artists pivot
        Schema::create('artist_track', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('track_id')->constrained()->cascadeOnDelete();
            $table->enum('role', ['primary', 'featuring', 'producer', 'composer', 'lyricist'])->default('featuring');
            $table->timestamps();

            $table->unique(['artist_id', 'track_id', 'role']);
        });

        // Track-Genre pivot
        Schema::create('genre_track', function (Blueprint $table) {
            $table->foreignId('genre_id')->constrained()->cascadeOnDelete();
            $table->foreignId('track_id')->constrained()->cascadeOnDelete();
            $table->primary(['genre_id', 'track_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('genre_track');
        Schema::dropIfExists('artist_track');
        Schema::dropIfExists('tracks');
    }
};
