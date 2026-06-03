<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notification_settings', function (Blueprint $table) {
            // JSON map of internal key => sms provider variable name
            // e.g. {"code": "OTP"} means when sending to sms.ir, 'code' param is sent as 'OTP'
            $table->json('sms_var_names')->nullable()->after('sms_pattern_id');
        });
    }

    public function down(): void
    {
        Schema::table('notification_settings', function (Blueprint $table) {
            $table->dropColumn('sms_var_names');
        });
    }
};
