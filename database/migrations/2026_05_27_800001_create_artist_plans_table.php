<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artist_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('duration_days')->default(30);
            $table->unsignedInteger('max_tracks')->default(0)->comment('0 = unlimited');
            $table->unsignedInteger('max_albums')->default(0)->comment('0 = unlimited');
            $table->unsignedBigInteger('max_storage_mb')->default(0)->comment('0 = unlimited');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('artist_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('artist_plans')->restrictOnDelete();
            $table->string('status')->default('active'); // active, expired, cancelled
            $table->timestamp('starts_at');
            $table->timestamp('expires_at')->nullable();
            $table->unsignedInteger('tracks_used')->default(0);
            $table->unsignedInteger('albums_used')->default(0);
            $table->unsignedBigInteger('storage_used_mb')->default(0);
            $table->string('payment_ref')->nullable();
            $table->foreignId('granted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_subscriptions');
        Schema::dropIfExists('artist_plans');
    }
};
