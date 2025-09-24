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
        Schema::create('infinity_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->nullable();
            $table->integer('reseller')->nullable();
            $table->text('slnoc')->nullable();
            $table->string('mac_address', 50)->nullable();
            $table->string('s1_ip_address', 50)->nullable();
            $table->string('s1_default_port', 11)->nullable();
            $table->string('s1_retry_port', 11)->nullable();
            $table->string('s2_default_port', 11)->nullable();
            $table->string('s2_retry_port', 11)->nullable();
            $table->string('firmware_upgrade', 11)->nullable();
            $table->string('firmware_server_path', 255)->nullable();
            $table->string('configuration_server_path', 255)->nullable();
            $table->string('parent_slnoc', 11)->nullable();
            $table->string('s2_ip_address', 50)->nullable();
            $table->string('phone_type', 50)->nullable();
            $table->string('activation_date', 11)->nullable();
            $table->string('expiry_date', 11)->nullable();
            $table->string('admin_pass', 255)->nullable();
            $table->string('wan_port_active', 25)->nullable();
            $table->string('wan_port_vid', 25)->nullable();
            $table->string('wan_port_priority', 5)->nullable();
            $table->string('pc_port_active', 25)->nullable();
            $table->string('pc_port_vid', 25)->nullable();
            $table->string('dhcp_vlan_active', 25)->nullable();
            $table->integer('updated')->nullable();
            $table->integer('created')->nullable();
            $table->string('auto_upgrade', 5)->nullable();
            $table->string('upgrade_exp_rom', 5)->nullable();
            $table->string('check_upgrade_times', 10)->nullable();
            $table->string('screansaver_server_url', 256)->nullable();
            $table->string('wallpaper_server_url', 256)->nullable();
            $table->string('wifi_node', 10)->nullable();
            $table->string('wifi_active', 10)->nullable();
            $table->string('wifi_security_mode', 10)->nullable();
            $table->string('wifi_ssid', 65)->nullable();
            $table->string('wifi_password', 65)->nullable();
            $table->string('firmware_server_path_enable', 10)->nullable();
            $table->string('configuration_server_path_enable', 10)->nullable();
            $table->string('screansaver_server_url_enable', 10)->nullable();
            $table->string('wallpaper_server_url_enable', 10)->nullable();
            $table->string('auto_upgrade_enable', 10)->nullable();
            $table->string('wifi_password_enable', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};