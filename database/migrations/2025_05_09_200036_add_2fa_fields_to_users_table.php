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
            $table->string('otp')->nullable()->after('password');
            $table->timestamp('otp_expires_at')->nullable()->after('otp');
            $table->string('last_login_ip')->nullable()->after('otp_expires_at');
            $table->string('last_login_device_id')->nullable()->after('last_login_ip');
            $table->timestamp('last_2fa_verified_at')->nullable()->after('last_login_device_id');
            $table->boolean('pending_2fa')->default(false)->after('otp_expires_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp', 'otp_expires_at', 'last_login_ip', 'last_login_device_id', 'last_2fa_verified_at','pending_2fa']);
        });
    }
};
