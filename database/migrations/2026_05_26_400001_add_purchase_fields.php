<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // discount_price روی tracks
        if (!Schema::hasColumn('tracks', 'discount_price')) {
            Schema::table('tracks', function (Blueprint $table) {
                $table->decimal('discount_price', 12, 0)->nullable()->after('price')
                    ->comment('قیمت با تخفیف (null = بدون تخفیف)');
            });
        }

        // discount_price روی albums
        if (!Schema::hasColumn('albums', 'discount_price')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->decimal('discount_price', 12, 0)->nullable()->after('price')
                    ->comment('قیمت با تخفیف (null = بدون تخفیف)');
            });
        }

        // includes_paid_content روی plans
        if (!Schema::hasColumn('plans', 'includes_paid_content')) {
            Schema::table('plans', function (Blueprint $table) {
                $table->boolean('includes_paid_content')->default(false)->after('unlimited_skips')
                    ->comment('دسترسی به تمام محتوای پولی');
            });
        }
    }

    public function down(): void
    {
        Schema::table('tracks', fn($t) => $t->dropColumn('discount_price'));
        Schema::table('albums', fn($t) => $t->dropColumn('discount_price'));
        Schema::table('plans', fn($t) => $t->dropColumn('includes_paid_content'));
    }
};
