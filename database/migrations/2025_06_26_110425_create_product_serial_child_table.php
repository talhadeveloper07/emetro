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
        Schema::create('product_serial_child', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('slno');
            $table->bigInteger('assigned_to_parent')->nullable();
            $table->integer('unit_per_block')->nullable();
            $table->integer('installation_date')->nullable();
            $table->integer('installed_by')->nullable();
            $table->integer('created')->nullable();
            $table->integer('updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serial_child');
    }
};
