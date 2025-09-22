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
        Schema::create('product_serial_notes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('slno')->nullable();
            $table->integer('date')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->integer('uid')->nullable();
            $table->integer('created')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serial_notes');
    }
};
