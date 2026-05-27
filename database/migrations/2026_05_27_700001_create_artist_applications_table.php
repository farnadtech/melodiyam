<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // فیلدهای قابل تنظیم توسط ادمین برای فرم درخواست
        Schema::create('artist_application_fields', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();           // نام داخلی: stage_name, national_id, ...
            $table->string('label');                   // برچسب نمایشی
            $table->string('type')->default('text');   // text, textarea, file, select, checkbox
            $table->json('options')->nullable();        // برای type=select: گزینه‌ها
            $table->boolean('required')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->string('placeholder')->nullable();
            $table->string('help_text')->nullable();
            $table->timestamps();
        });

        // جدول اصلی درخواست‌های هنرمند
        Schema::create('artist_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('data');                      // داده‌های پر شده توسط کاربر
            $table->enum('status', ['pending', 'reviewing', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique('user_id'); // هر کاربر فقط یک درخواست
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_applications');
        Schema::dropIfExists('artist_application_fields');
    }
};
