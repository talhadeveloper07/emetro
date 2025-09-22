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
            // Rename weight to net_weight
            $table->renameColumn('weight', 'net_weight');

            // Add remaining fields
            $table->double('gross_weight', 8, 2)->nullable()->after('net_weight');
            $table->enum('weight_unit', ['kg', 'lb'])->nullable()->after('gross_weight');
            $table->enum('dimension_unit', ['cm', 'in'])->nullable()->after('dimension_height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert changes
            $table->renameColumn('net_weight', 'weight');
            $table->dropColumn('gross_weight');
            $table->dropColumn('weight_unit');
            $table->dropColumn('dimension_unit');
        });
    }
};
