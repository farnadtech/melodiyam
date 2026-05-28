<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->string('status', 20)->default('draft')->change();
        });
        Schema::table('albums', function (Blueprint $table) {
            $table->string('status', 20)->default('draft')->change();
        });
        Schema::table('podcasts', function (Blueprint $table) {
            $table->string('status', 20)->default('draft')->change();
        });
    }

    public function down(): void
    {
        // No reverse needed as string is more flexible than enum
    }
};
