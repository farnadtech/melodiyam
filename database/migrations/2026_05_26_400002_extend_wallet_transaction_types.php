<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: modify enum to add purchase and sale_income types
        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('deposit','withdrawal','purchase','sale_income','refund') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE wallet_transactions MODIFY COLUMN type ENUM('deposit','withdrawal') NOT NULL");
    }
};
