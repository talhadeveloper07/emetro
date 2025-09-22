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
        Schema::create('order_headers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid')->nullable();
            $table->string('sid')->nullable();
            $table->string('end_customer')->nullable();
            $table->longText('address')->nullable();
            $table->string('reseller_id')->nullable();
            $table->double('total')->nullable();
            $table->double('balance')->nullable();
            $table->double('dicount')->nullable();
            $table->integer('status')->nullable();
            $table->date('quote_date')->nullable();
            $table->string('type')->nullable();
            $table->boolean('support_discount')->nullable();
            $table->boolean('invoice_status')->nullable();
            $table->longText('data')->nullable();
            $table->longText('payment_status')->nullable();
            $table->string('order_status')->nullable();
            $table->string('extra_discount')->nullable();
            $table->string('paid_category')->nullable();
            $table->string('software_po')->nullable();
            $table->string('billing_option')->nullable();
            $table->bigInteger('end_customer_id')->nullable();
            $table->string('payment_error')->nullable();
            $table->string('monthly')->nullable();
            $table->bigInteger('quote_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_headers');
    }
};
