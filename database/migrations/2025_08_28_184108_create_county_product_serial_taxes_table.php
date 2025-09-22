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
        Schema::create('county_product_serial_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('state', 100)->nullable();
            $table->string('county', 255)->nullable();
            $table->double('percentage')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('county_product_serial_taxes');
    }
};
