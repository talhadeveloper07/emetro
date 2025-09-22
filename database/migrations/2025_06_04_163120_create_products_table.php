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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->string('product_type')->nullable(); // hardware, software, services
            $table->string('product_sub_type')->nullable(); // monthly, annual, one time
            $table->string('image')->nullable();
            $table->string('title', 50)->nullable();
            $table->string('small_title', 50)->nullable();
            $table->integer('sort_order')->nullable();
            $table->string('description', 120)->nullable();
            $table->text('additional_information')->nullable();
            $table->string('sw_subscription_per_year_p')->nullable();
            $table->string('sw_subscription_per_month_p')->nullable();
            $table->string('hw_warranty_per_year_price')->nullable();
            $table->string('assurance_renewal')->nullable(); // yes, no
            $table->unsignedBigInteger('discount_category_id')->nullable();
            $table->foreign('discount_category_id')->references('id')->on('discounts')->onDelete('set null');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
            $table->string('inventory_location')->nullable();
            $table->integer('inventory_count')->nullable();
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->decimal('product_unit_cost', 10, 2)->nullable();
            $table->string('status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
