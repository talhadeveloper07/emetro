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
        Schema::create('product_serial_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_slno')->nullable();
            $table->string('function_name', 255);
            $table->text('message')->nullable();
            $table->longText('data')->nullable();
            $table->string('uid', 25)->nullable();
            $table->string('interface', 255)->nullable();
            $table->integer('created')->nullable(); // Assuming UNIX timestamp
            $table->unsignedInteger('re_seller')->nullable();

            $table->index('parent_slno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serial_log');
    }
};
