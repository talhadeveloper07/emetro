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
        Schema::create('product_serial_parent_child', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('slno')->unique()->nullable();
            $table->string('customer_name', 256)->nullable();
            $table->integer('installation_date')->nullable();
            $table->string('site_name', 256)->nullable();
            $table->integer('installed_by')->nullable();
            $table->string('dealer_email', 256)->nullable();
            $table->string('site_status', 50)->nullable();
            $table->string('service_vpn', 100)->nullable();
            $table->string('configuration', 50)->nullable();
            $table->string('profile_format', 255)->nullable();
            $table->string('service_format', 50)->nullable();
            $table->string('customer_email_address', 255)->nullable();
            $table->string('customer_phone_number', 255)->nullable();
            $table->bigInteger('support_start_date')->nullable();
            $table->string('support_duration', 255)->nullable();
            $table->bigInteger('support_renewal_date')->nullable();
            $table->string('support_status', 255)->nullable();
            $table->bigInteger('warranty_start_date')->nullable();
            $table->string('warranty_duration', 255)->nullable();
            $table->bigInteger('warranty_renewal_date')->nullable();
            $table->string('warranty_status', 255)->nullable();
            $table->string('host_id', 255)->nullable();
            $table->integer('sip_trunks')->nullable();
            $table->integer('did_numbers')->nullable();
            $table->string('cloud_status', 255)->nullable();
            $table->string('sw_version', 255)->nullable();
            $table->integer('extensions')->nullable();
            $table->string('voice_services', 255)->nullable();
            $table->string('ucx_applications', 255)->nullable();
            $table->string('ucx_integration_app', 255)->nullable();
            $table->integer('hospitality')->nullable();
            $table->integer('toll_free_numbers')->nullable();
            $table->mediumText('note_public')->nullable();
            $table->mediumText('note_private')->nullable();
            $table->string('host_version', 255)->nullable();
            $table->string('host_internal_trucks', 255)->nullable();
            $table->string('tag_number', 255)->nullable();
            $table->text('retired_host_ids')->nullable();
            $table->integer('e_metrotel_ext')->nullable();
            $table->integer('universal_ext')->nullable();
            $table->integer('basic_ext')->nullable();
            $table->integer('sr_ext')->nullable();
            $table->integer('internal_tdm_trunks')->nullable();
            $table->integer('1_fxo')->nullable();
            $table->integer('4_fxo')->nullable();
            $table->integer('1_fxs')->nullable();
            $table->integer('4_fxs')->nullable();
            $table->string('status_type', 255)->nullable();
            $table->text('status_message')->nullable();
            $table->integer('updated')->nullable();
            $table->integer('created')->nullable();
            $table->string('support_type', 255)->default('standard');
            $table->string('source', 255)->nullable();
            $table->double('monthly_amount')->nullable();
            $table->string('retired_host_id1', 255)->nullable();
            $table->string('retired_host_note1', 255)->nullable();
            $table->string('retired_host_id2', 255)->nullable();
            $table->string('retired_host_note2', 255)->nullable();
            $table->string('retired_host_note3', 255)->nullable();
            $table->string('retired_host_id3', 255)->nullable();
            $table->string('retired_host_note4', 255)->nullable();
            $table->string('retired_host_id4', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serial_parent_child');
    }
};
