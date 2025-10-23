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
        Schema::create('templates', function (Blueprint $table) {
            $table->id(); 
            $table->string('template_name', 255)->nullable();
            $table->string('vendor', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('re_seller', 255)->nullable();
            $table->date('modified_date')->nullable();
            $table->string('file_location', 255)->nullable();
            $table->integer('file_id')->nullable();
            $table->string('file_name', 255)->nullable();
            $table->boolean('is_default')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
