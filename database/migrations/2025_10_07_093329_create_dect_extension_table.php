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
        Schema::create('dect_extension', function (Blueprint $table) {
            $table->id(); // id (Primary Key, Auto Increment)

            $table->string('extension', 100)->unique(); // Extension number is unique
            $table->string('secret', 100)->nullable(); // Secret can be null
            $table->string('display_name', 100)->nullable(); // Display name can be null
            $table->string('index', 11)->nullable(); // Index can be null
            $table->string('mac', 100); // MAC address, required

            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dect_extension');
    }
};
