<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['audio', 'banner', 'video', 'sponsored_track', 'sponsored_playlist'])->default('banner');
            $table->string('media_path')->nullable();
            $table->string('media_url')->nullable();
            $table->string('click_url')->nullable();
            $table->string('position')->nullable(); // header, sidebar, player, between-tracks
            $table->unsignedInteger('duration')->nullable(); // for audio/video ads
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->enum('status', ['draft', 'active', 'paused', 'expired'])->default('draft');
            $table->unsignedBigInteger('impressions')->default(0);
            $table->unsignedBigInteger('clicks')->default(0);
            $table->unsignedBigInteger('max_impressions')->nullable();
            $table->decimal('budget', 12, 0)->nullable();
            $table->decimal('spent', 12, 0)->default(0);
            $table->json('targeting')->nullable(); // age, gender, location, genre
            $table->unsignedInteger('priority')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'starts_at', 'ends_at']);
            $table->index('type');
        });

        Schema::create('ad_impressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('event', ['impression', 'click', 'complete'])->default('impression');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['advertisement_id', 'event']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_impressions');
        Schema::dropIfExists('advertisements');
    }
};
