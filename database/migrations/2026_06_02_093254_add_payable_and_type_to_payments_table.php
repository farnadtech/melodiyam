<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // What was paid for: subscription, artist_subscription, wallet_deposit
            $table->string('payment_type')->default('subscription')->after('gateway');
            // Polymorphic: points to the related model (Subscription, ArtistSubscription, Wallet)
            $table->nullableMorphs('payable');
            // Tax and fee breakdown
            $table->decimal('tax_amount', 12, 0)->default(0)->after('amount');
            $table->decimal('fee_amount', 12, 0)->default(0)->after('tax_amount');
            // Callable back URL (for wallet top-up)
            $table->text('callback_url')->nullable()->after('description');
            // Mobile (required by PayPing)
            $table->string('mobile', 15)->nullable()->after('callback_url');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'tax_amount', 'fee_amount', 'callback_url', 'mobile']);
            $table->dropMorphs('payable');
        });
    }
};
