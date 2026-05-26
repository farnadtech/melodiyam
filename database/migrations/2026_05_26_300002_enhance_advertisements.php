<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            // پلن‌های هدف (json array از plan slugs)
            if (!Schema::hasColumn('advertisements', 'target_plans')) {
                $table->json('target_plans')->nullable()->after('targeting')
                    ->comment('پلن‌هایی که این آگهی نمایش داده می‌شود');
            }
            // فاصله بین تبلیغات (ثانیه)
            if (!Schema::hasColumn('advertisements', 'interval_seconds')) {
                $table->unsignedInteger('interval_seconds')->default(300)->after('duration')
                    ->comment('هر چند ثانیه یک تبلیغ پخش شود');
            }
            // تعداد آهنگ بین تبلیغات
            if (!Schema::hasColumn('advertisements', 'tracks_between')) {
                $table->unsignedInteger('tracks_between')->default(3)->after('interval_seconds')
                    ->comment('هر چند آهنگ یک تبلیغ پخش شود');
            }
        });
    }

    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn(['target_plans', 'interval_seconds', 'tracks_between']);
        });
    }
};
