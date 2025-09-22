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
        Schema::create('order_hardware', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('distributer')->nullable();
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->string('reseller_order_id')->nullable();
            $table->string('account_on_file')->nullable();
            $table->string('account_no')->nullable();
            $table->string('carrier')->nullable();
            $table->string('shipping_location_name')->nullable();
            $table->string('shipping_street_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('att')->nullable();
            $table->string('billing_location_name')->nullable();
            $table->string('billing_street_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip_code')->nullable();
            $table->string('email')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('billing_country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_hardware');
    }
};
