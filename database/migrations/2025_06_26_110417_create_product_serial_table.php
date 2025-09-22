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
        Schema::create('product_serial', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('slno')->unique();
            $table->string('status', 50)->default('');
            $table->string('type', 50)->nullable();
            $table->string('product_code', 50)->nullable();
            $table->string('vendor', 50)->nullable();
            $table->string('distributor', 50)->nullable();
            $table->bigInteger('re_seller')->nullable();
            $table->string('description', 255)->nullable();
            $table->string('mac_address_0', 255)->nullable();
            $table->string('mac_address_1', 255)->nullable();
            $table->string('host_id', 255)->nullable();
            $table->integer('updated')->nullable();
            $table->integer('created')->nullable();
            $table->string('invoice', 255)->nullable();
            $table->string('po_serial', 255)->nullable();
            $table->string('source', 255)->nullable();
            $table->string('software_po', 50)->nullable();
            $table->string('rma_id', 50)->nullable();
            $table->string('billing_option', 100)->nullable();
            $table->integer('end_customer_id')->nullable();
            $table->string('auto_renewal', 10)->default('Yes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serial');
    }
};
