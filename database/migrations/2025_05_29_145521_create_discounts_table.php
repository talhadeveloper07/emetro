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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->double('amount', 10, 2)->nullable();
            $table->boolean('status')->default(1)->nullable();
            $table->timestamps();
        });
        // Seed initial discounts
        $discounts = [
            'Appliances', 'Gateway cards', 'Terminals', 'Extensions', 'Applications',
            'UCX Cloud Services', 'Sip Trunks Channel', 'Other Sip Trunks Services',
            'Assurance Services', 'DSM16'
        ];

        foreach ($discounts as $discount) {
            \App\Models\Discount::create(['name' => $discount]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
