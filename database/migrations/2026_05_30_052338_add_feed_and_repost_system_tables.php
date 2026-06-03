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
        // 1. Update plans table
        Schema::table('plans', function (Blueprint $table) {
            $table->boolean('can_upload_music')->default(false)->after('includes_downloads');
            $table->integer('max_music_uploads')->default(0)->after('can_upload_music');
        });

        // 2. Update tracks table
        Schema::table('tracks', function (Blueprint $table) {
            $table->foreignId('artist_id')->nullable()->change();
            $table->foreignId('user_id')->nullable()->after('artist_id')->constrained()->nullOnDelete();
            $table->unsignedBigInteger('repost_count')->default(0)->after('share_count');
            $table->unsignedBigInteger('comment_count')->default(0)->after('repost_count');
        });

        // 3. Update albums table
        Schema::table('albums', function (Blueprint $table) {
            $table->unsignedBigInteger('repost_count')->default(0)->after('like_count');
            $table->unsignedBigInteger('comment_count')->default(0)->after('repost_count');
            $table->unsignedBigInteger('share_count')->default(0)->after('comment_count');
        });

        // 4. Update podcasts table
        Schema::table('podcasts', function (Blueprint $table) {
            $table->unsignedBigInteger('repost_count')->default(0)->after('subscribers_count');
            $table->unsignedBigInteger('comment_count')->default(0)->after('repost_count');
            $table->unsignedBigInteger('share_count')->default(0)->after('comment_count');
            $table->unsignedBigInteger('like_count')->default(0)->after('share_count');
        });

        // 5. Create activities table
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // track_published, album_published, podcast_published, reposted
            $table->morphs('subject');
            $table->timestamps();
            
            $table->index('type');
        });

        // 6. Create reposts table
        Schema::create('reposts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('repostable');
            $table->timestamps();

            $table->unique(['user_id', 'repostable_type', 'repostable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reposts');
        Schema::dropIfExists('activities');

        Schema::table('podcasts', function (Blueprint $table) {
            $table->dropColumn(['repost_count', 'comment_count', 'share_count', 'like_count']);
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn(['repost_count', 'comment_count', 'share_count']);
        });

        Schema::table('tracks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'repost_count', 'comment_count']);
            $table->foreignId('artist_id')->nullable(false)->change();
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['can_upload_music', 'max_music_uploads']);
        });
    }
};
