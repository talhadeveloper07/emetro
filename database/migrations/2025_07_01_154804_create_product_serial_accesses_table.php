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
        Schema::create('product_serial_access', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('slno')->nullable();
            $table->string('hostname', 100)->nullable();
            $table->string('vpn', 100)->nullable();
            $table->string('username', 50)->nullable();
            $table->string('password', 50)->nullable();
            $table->string('public_ip', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serial_access');
    }
};
