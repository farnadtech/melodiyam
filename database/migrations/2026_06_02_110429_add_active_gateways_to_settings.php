<?php
use Illuminate\Database\Migrations\Migration;
return new class extends Migration {
    public function up(): void {
        // active_gateways stored as JSON in settings key-value table — no schema change needed
    }
    public function down(): void {}
};
