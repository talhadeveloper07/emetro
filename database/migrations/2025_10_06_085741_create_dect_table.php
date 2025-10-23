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
        Schema::create('dect', function (Blueprint $table) {
            $table->increments('id'); // Primary key, auto-increment
            $table->string('mac', 100)->unique()->comment('MAC (Hexadecimal converted to all lowercase)');
            $table->string('re_seller', 100)->nullable()->comment('Organization');
            $table->string('slno', 100)->nullable();
            $table->string('model', 60)->nullable();
            $table->integer('extension')->default(0);
            $table->integer('last_push')->nullable();
            $table->string('sip_mode', 100)->nullable();
            $table->string('sip_server_address', 100)->nullable();
            $table->string('sip_server_port', 100)->nullable();
            $table->string('time_server', 256)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('region', 255)->nullable();
            $table->string('codec_priority', 255)->nullable();
            $table->string('primary_mac', 100)->nullable();
            $table->integer('index_assigned')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dect');
    }
};
