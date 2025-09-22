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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('org_id')->after('id')->nullable();
            $table->string('first_name')->after('name')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('office_phone')->after('email')->nullable();
            $table->string('cell')->after('office_phone')->nullable();
            $table->text('created_by')->nullable();
            $table->text('updated_by')->nullable();
            $table->string('ucx_course')->nullable();
            $table->string('infinity_one_course')->nullable();
            $table->string('job_title')->nullable();
            $table->string('courses')->nullable();
            $table->string('newsletter_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['org_id','first_name','last_name','office_phone','cell','created_by','updated_by','ucx_course','infinity_one_course','job_title','courses','newsletter_id']);
        });
    }
};
