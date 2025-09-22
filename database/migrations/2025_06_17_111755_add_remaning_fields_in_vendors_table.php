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
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('address')->after('name')->nullable();
            $table->string('country')->after('address')->nullable();
            $table->string('payment_detail')->after('country')->nullable();
            $table->string('currency')->after('payment_detail')->nullable();
            $table->string('point_of_contact')->after('currency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn(['address','country','payment_detail','currency','point_of_contact']);

        });
    }
};
