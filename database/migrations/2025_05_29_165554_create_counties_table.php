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
        Schema::create('county_fips', function (Blueprint $table) {
            $table->id();
            $table->string('fips_state', 2)->comment('The FIPS code for the state.')->nullable();
            $table->string('fips_county', 3)->comment('The FIPS code for the county.')->nullable();
            $table->string('fips_class', 2)->comment('The FIPS (or census) code for the administrative area class.')->nullable();
            $table->string('state', 2)->comment('The 2-character US state code.')->nullable();
            $table->string('county', 48)->comment('The US administrative area name.')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('county_fips');
    }
};
