<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earnings_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_enabled')->default(false);
            $table->integer('plays_threshold')->default(100); // n plays required to earn
            $table->integer('earning_amount_toman')->default(500); // x toman per threshold
            $table->integer('min_payout_toman')->default(50000); // minimum payout
            $table->text('payout_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('earnings_settings');
    }
};
