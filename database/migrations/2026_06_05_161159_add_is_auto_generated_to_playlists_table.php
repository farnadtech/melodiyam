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
        Schema::table('playlists', function (Blueprint $table) {
            $table->boolean('is_auto_generated')->default(false)->after('is_sponsored');
            $table->string('template_key')->nullable()->after('is_auto_generated');
            $table->index(['user_id', 'is_auto_generated']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'is_auto_generated']);
            $table->dropColumn(['is_auto_generated', 'template_key']);
        });
    }
};
