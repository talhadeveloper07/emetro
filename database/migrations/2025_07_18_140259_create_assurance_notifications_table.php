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
        Schema::create('assurance_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('slno')->nullable();
            $table->string('subject', 255)->nullable();
            $table->longText('mail_message')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('installed_by')->nullable();
            $table->string('message_type', 50)->nullable();
            $table->integer('alert_status')->nullable();
            $table->integer('mail_status')->nullable();
            $table->integer('assurance_quote_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('template_id')->nullable();
            $table->string('to', 1000)->nullable();
            $table->longText('attachment_content')->nullable();
            $table->string('attachment_filename', 255)->nullable();
            $table->string('attachment_file_type', 255)->nullable();
            $table->timestamps();

            $table->index('slno');
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assurance_notifications');
    }
};
