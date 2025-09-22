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
        Schema::table('soft_phone_provisioning', function (Blueprint $table) {
            $table->unsignedBigInteger('org_id')->nullable()->after('slno');

            // Add foreign key constraint
            $table->foreign('org_id')
                  ->references('id')
                  ->on('organizations')
                  ->onDelete('set null'); // if org deleted, keep record but nullify org_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('soft_phone_provisioning', function (Blueprint $table) {
            $table->dropForeign(['org_id']);
            $table->dropColumn('org_id');
        });
    }
};
