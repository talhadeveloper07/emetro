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
        Schema::create('infinity_list_custom_variables', function (Blueprint $table) {
            $table->id();
            $table->string('parent_slno', 50)->nullable();
            $table->string('slno', 50)->nullable();
            $table->string('pcode', 100)->nullable();
            $table->string('pvalue', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infinity_list_custom_variables');
    }
};
