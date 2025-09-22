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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });
        // Seed initial vendors
        $vendors = ['E-MetroTel', 'Htek', 'OpenVox', 'Unicom', 'Dinstar'];

        foreach ($vendors as $vendor) {
            \App\Models\Vendor::create(['name' => $vendor]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
