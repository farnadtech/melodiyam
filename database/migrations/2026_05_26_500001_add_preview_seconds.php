<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->unsignedSmallInteger('preview_seconds')->default(0)->after('discount_price');
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->unsignedSmallInteger('preview_seconds')->default(0)->after('discount_price');
        });
    }

    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('preview_seconds');
        });
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('preview_seconds');
        });
    }
};
