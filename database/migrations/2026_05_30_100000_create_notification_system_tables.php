<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('driver'); // melipayamak, smsir
            $table->json('credentials');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->string('event_key')->unique();
            $table->string('event_label');
            $table->string('recipient_type'); // user, artist, admin
            $table->boolean('via_database')->default(true);
            $table->boolean('via_sms')->default(false);
            $table->boolean('via_email')->default(false);
            $table->string('sms_pattern_id')->nullable();
            $table->text('sms_template')->nullable();
            $table->string('email_subject')->nullable();
            $table->text('email_body')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
        Schema::dropIfExists('sms_providers');
    }
};
