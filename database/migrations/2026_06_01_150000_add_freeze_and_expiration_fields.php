<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom active_period_months di tabel packages
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('active_period_months')->default(1)->after('sessions');
        });

        // 2. Isi default masa berlaku paket lama
        // 4x -> 1 bulan, 8x -> 2 bulan, 30x -> 3 bulan, lainnya default 1 bulan
        DB::table('packages')->where('sessions', '<=', 4)->update(['active_period_months' => 1]);
        DB::table('packages')->where('sessions', '>', 4)->where('sessions', '<=', 8)->update(['active_period_months' => 2]);
        DB::table('packages')->where('sessions', '>', 8)->update(['active_period_months' => 3]);

        // 3. Tambah kolom di tabel students untuk freeze & expiration
        Schema::table('students', function (Blueprint $table) {
            $table->timestamp('package_activated_at')->nullable()->after('status');
            $table->timestamp('package_expires_at')->nullable()->after('package_activated_at');
            $table->timestamp('suspended_at')->nullable()->after('package_expires_at');
            $table->string('suspension_reason')->nullable()->after('suspended_at');
        });

        // 4. Ubah tipe kolom status di tabel students agar lebih fleksibel mendukung 'suspended' dan status baru lainnya
        Schema::table('students', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['package_activated_at', 'package_expires_at', 'suspended_at', 'suspension_reason']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('active_period_months');
        });
    }
};
