<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('category')->nullable();
            $table->string('language', 5)->default('fa');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_explicit')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('subscribers_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('is_featured');
        });

        Schema::create('podcast_episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('podcast_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('show_notes')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();
            $table->unsignedInteger('duration')->default(0);
            $table->unsignedSmallInteger('season_number')->nullable();
            $table->unsignedSmallInteger('episode_number')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_explicit')->default(false);
            $table->boolean('is_premium_only')->default(false);
            $table->unsignedBigInteger('play_count')->default(0);
            $table->unsignedBigInteger('like_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->unique(['podcast_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('podcast_episodes');
        Schema::dropIfExists('podcasts');
    }
};
