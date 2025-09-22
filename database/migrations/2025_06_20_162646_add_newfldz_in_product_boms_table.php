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
        Schema::table('product_boms', function (Blueprint $table) {
            $table->string('hts')->after('vendor')->nullable();
            $table->string('eccn')->after('hts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_boms', function (Blueprint $table) {
            $table->dropColumn(['hts','eccn']);
        });
    }
};
