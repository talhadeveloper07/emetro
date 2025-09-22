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

        Schema::create('price_regions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Seed initial price regions
        \App\Models\PriceRegion::create(['name' => 'USA']);
        \App\Models\PriceRegion::create(['name' => 'Australia']);
        \App\Models\PriceRegion::create(['name' => 'Europe']);
        \App\Models\PriceRegion::create(['name' => 'Canada']);
        \App\Models\PriceRegion::create(['name' => 'International']);
        \App\Models\PriceRegion::create(['name' => 'Europe 2']);
        \App\Models\PriceRegion::create(['name' => 'Europe 3']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_regions');
    }
};
