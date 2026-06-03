<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Email template is stored in the settings key-value table, no schema change needed.
        // This migration is intentionally empty — the setting key 'email_layout_template'
        // is managed through the Settings model like all other settings.
    }

    public function down(): void
    {
        //
    }
};
