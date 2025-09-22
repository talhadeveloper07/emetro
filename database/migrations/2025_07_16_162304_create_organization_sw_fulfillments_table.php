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
        Schema::create('organization_sw_fulfillments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('org_nid')->nullable();
            $table->bigInteger('sw_fulfillment_nid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_sw_fulfillments');
    }
};
