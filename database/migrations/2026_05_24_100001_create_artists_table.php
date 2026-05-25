<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('display_name');
            $table->string('slug')->unique();
            $table->text('bio')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('telegram')->nullable();
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('monthly_listeners')->default(0);
            $table->unsignedBigInteger('total_streams')->default(0);
            $table->unsignedBigInteger('followers_count')->default(0);
            $table->decimal('balance', 12, 0)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('verification_status');
            $table->index('is_featured');
            $table->index('monthly_listeners');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
