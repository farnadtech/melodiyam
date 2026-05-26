<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('type');
            $table->string('reference_number')->nullable()->after('description'); // شماره پیگیری
            $table->string('card_number')->nullable()->after('reference_number'); // ۴ رقم آخر کارت
            $table->string('receipt_image')->nullable()->after('card_number');    // تصویر رسید
            $table->string('admin_note')->nullable()->after('receipt_image');     // یادداشت ادمین
            $table->unsignedBigInteger('reviewed_by')->nullable()->after('admin_note');
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });
    }

    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn(['status', 'reference_number', 'card_number', 'receipt_image', 'admin_note', 'reviewed_by', 'reviewed_at']);
        });
    }
};
