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
        Schema::create('order_tax_collecteds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->double('tax')->nullable();
            $table->double('percentage')->nullable();
            $table->double('county_tax')->nullable();
            $table->double('county_percentage')->nullable();
            $table->double('fcc_amount')->nullable();
            $table->double('fcc_percentage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tax_collecteds');
    }
};
