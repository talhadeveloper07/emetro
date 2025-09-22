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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 500)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('cell', 50)->nullable();
            $table->string('billing_address_1', 255)->nullable();
            $table->string('billing_address_2', 255)->nullable();
            $table->string('billing_city', 255)->nullable();
            $table->string('billing_state', 100)->nullable();
            $table->string('billing_country', 100)->nullable();
            $table->string('billing_zip', 50)->nullable();
            $table->string('source', 50)->nullable();
            $table->string('website', 256)->nullable();
            $table->string('tags', 255)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('created_by', 100)->nullable();
            $table->string('update_by', 255)->nullable();
            $table->string('org_type', 50)->nullable();
            $table->string('first_contact', 11)->nullable();
            $table->bigInteger('nid')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('shipping_address_1', 255)->nullable();
            $table->string('shipping_address_2', 255)->nullable();
            $table->string('shipping_city', 255)->nullable();
            $table->string('shipping_state', 100)->nullable();
            $table->string('shipping_country', 100)->nullable();
            $table->string('shipping_zip', 50)->nullable();
            $table->string('billing_county', 60)->nullable();
            $table->string('shipping_county', 60)->nullable();
            $table->string('master_reseller', 50)->nullable();
            $table->string('distributer', 100)->nullable();
            $table->string('emt_contact', 50)->nullable();
            $table->string('tax_id', 50)->nullable();
            $table->string('no_of_emp', 11)->nullable();
            $table->text('logo')->nullable();
            $table->string('archive')->default(0)->nullable();
            $table->text('note')->nullable();
            $table->string('tax_exemption', 50)->default('No')->nullable();
            $table->string('payout_email', 255)->nullable();
            $table->string('payout_status', 50)->default('Enable')->nullable();
            $table->string('payout_type', 50)->nullable();
            $table->string('direct_hardware', 50)->nullable();
            $table->string('hardware_direct_email', 255)->nullable();
            $table->string('direct_software', 50)->nullable();
            $table->string('software_direct_email', 255)->nullable();
            $table->string('software_distributer', 255)->nullable();
            $table->string('price_type', 50)->nullable();
            $table->string('agent_name', 20)->nullable();
            $table->string('agent_start', 50)->nullable();
            $table->timestamps();
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
