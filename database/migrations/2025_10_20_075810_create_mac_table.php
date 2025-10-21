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
        Schema::create('mac', function (Blueprint $table) {
            $table->id(); // id int(11) AUTO_INCREMENT PRIMARY KEY
            $table->string('mac', 255); // not nullable
            $table->string('vendor', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('template_name', 255)->nullable();
            $table->string('re_seller', 255)->nullable();
            $table->date('modified_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mac');
    }
};
