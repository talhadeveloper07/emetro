<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organization_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_nid')->nullable();
            $table->boolean('is_paypal')->nullable()->default(false);
            $table->boolean('is_stripe')->nullable()->default(false);
            $table->boolean('is_emtpay')->nullable()->default(false);
            $table->boolean('is_term')->nullable()->default(false);
            $table->boolean('is_ach')->nullable()->default(false);
            $table->boolean('is_create_order')->nullable()->default(false);
            $table->boolean('is_emtpay_topup')->nullable()->default(false);
            $table->boolean('save_credit_card')->nullable()->default(false);
            $table->boolean('monthly_bill_auto_payment')->nullable()->default(false);
            $table->boolean('annual_bill_auto_payment')->nullable()->default(false);
            $table->boolean('force_direct_customer_billing')->nullable()->default(false);
            $table->decimal('payment_terms_credit_limit', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_settings');
    }
};
