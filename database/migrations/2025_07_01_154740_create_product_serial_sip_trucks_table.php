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
        Schema::create('product_serial_sip_truck', function (Blueprint $table) {
            $table->id();
            $table->string('slno', 50)->nullable();
            $table->integer('order_id')->nullable();
            $table->string('public_ip')->nullable();
            $table->string('port', 50)->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_country', 50)->nullable();
            $table->string('customer_address1')->nullable();
            $table->string('customer_address2')->nullable();
            $table->string('customer_city', 100)->default('');
            $table->string('customer_state', 100)->nullable();
            $table->string('customer_zip', 50)->nullable();
            $table->integer('sip_trucks')->nullable();
            $table->string('truck_name')->nullable();
            $table->integer('did_numbers')->nullable();
            $table->string('area_code', 50)->nullable();
            $table->integer('listing_911')->nullable();
            $table->string('order_country', 50)->nullable();
            $table->string('order_address1')->nullable();
            $table->string('order_address2')->nullable();
            $table->string('order_city', 50)->nullable();
            $table->string('order_state', 50)->nullable();
            $table->string('order_zip', 50)->nullable();
            $table->string('911_caller', 100)->nullable();
            $table->integer('did_number_requested')->nullable();
            $table->integer('updated')->nullable();
            $table->integer('created')->nullable();
            $table->string('authentication_type', 4)->nullable();
            $table->string('voip_password', 100)->nullable();
            $table->string('source_type', 50)->nullable();
            $table->string('instance_type', 50)->nullable();
            $table->string('manufacture', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('voip_username', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('default_did', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serial_sip_truck');
    }
};
