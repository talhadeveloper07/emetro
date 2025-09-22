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
        Schema::table('products', function (Blueprint $table) {
            $table->double('dimension_length', 8, 2)->nullable();
            $table->double('dimension_width', 8, 2)->nullable();
            $table->double('dimension_height', 8, 2)->nullable();
            $table->double('weight', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['dimension_length','dimension_width','dimension_height','weight']);
        });
    }
};
