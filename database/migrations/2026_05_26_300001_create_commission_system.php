<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول قوانین کمیسیون
        if (!Schema::hasTable('commission_rules')) {
            Schema::create('commission_rules', function (Blueprint $table) {
                $table->id();
                $table->string('name')->comment('نام قانون');
                $table->enum('type', ['global', 'genre', 'artist'])->default('global');
                $table->unsignedBigInteger('reference_id')->nullable()->comment('genre_id یا artist_id');
                $table->enum('commission_type', ['percent', 'fixed'])->default('percent');
                $table->decimal('commission_value', 8, 2)->default(20)->comment('درصد یا مبلغ ثابت');
                $table->boolean('is_active')->default(true);
                $table->text('description')->nullable();
                $table->timestamps();
                $table->index(['type', 'reference_id']);
            });
        }

        // جدول فروش‌ها (track/album purchases)
        if (!Schema::hasTable('sales')) {
            Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete()->comment('artist user_id');
            $table->morphs('saleable'); // track یا album
            $table->decimal('gross_amount', 12, 0)->comment('مبلغ کل پرداختی خریدار');
            $table->decimal('commission_amount', 12, 0)->default(0)->comment('کمیسیون پلتفرم');
            $table->decimal('net_amount', 12, 0)->comment('درآمد خالص هنرمند');
            $table->foreignId('commission_rule_id')->nullable()->constrained('commission_rules')->nullOnDelete();
            $table->enum('status', ['pending', 'completed', 'refunded'])->default('completed');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();
            $table->index(['seller_id', 'status']);
            $table->index(['buyer_id', 'status']);
            });
        }

        // track_price و album_price - قابلیت فروش اضافه
        if (!Schema::hasColumn('tracks', 'price')) {
            Schema::table('tracks', function (Blueprint $table) {
                $table->decimal('price', 12, 0)->nullable()->comment('قیمت (null = رایگان)');
                $table->boolean('is_for_sale')->default(false);
            });
        }

        if (!Schema::hasColumn('albums', 'price')) {
            Schema::table('albums', function (Blueprint $table) {
                $table->decimal('price', 12, 0)->nullable()->comment('قیمت (null = رایگان)');
                $table->boolean('is_for_sale')->default(false);
            });
        }
    }

    public function down(): void
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn(['price', 'is_for_sale']);
        });
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn(['price', 'is_for_sale']);
        });
        Schema::dropIfExists('sales');
        Schema::dropIfExists('commission_rules');
    }
};
