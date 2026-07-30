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
        // 1. Tambahkan kolom snapshot pada tabel payments jika belum ada
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'student_name')) {
                $table->string('student_name')->nullable()->after('student_id');
            }
            if (!Schema::hasColumn('payments', 'user_name')) {
                $table->string('user_name')->nullable()->after('student_name');
            }
            if (!Schema::hasColumn('payments', 'package_name')) {
                $table->string('package_name')->nullable()->after('user_name');
            }
        });

        // 2. Isi data snapshot untuk transaksi payments yang sudah ada saat ini
        $existingPayments = DB::table('payments')
            ->join('students', 'payments.student_id', '=', 'students.id')
            ->leftJoin('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('packages', 'students.package_id', '=', 'packages.id')
            ->select(
                'payments.id',
                'students.name as student_name',
                'users.name as user_name',
                'packages.name as package_name'
            )
            ->get();

        foreach ($existingPayments as $p) {
            DB::table('payments')->where('id', $p->id)->update([
                'student_name' => $p->student_name,
                'user_name' => $p->user_name,
                'package_name' => $p->package_name,
            ]);
        }

        // 3. Ubah foreign key student_id pada payments agar nullOnDelete (tidak menghapus riwayat saat murid dihapus)
        Schema::table('payments', function (Blueprint $table) {
            // Drop foreign key lama
            $table->dropForeign(['student_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            // Re-add foreign key nullable & nullOnDelete
            $table->unsignedBigInteger('student_id')->nullable()->change();
            $table->foreign('student_id')->references('id')->on('students')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->change();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->dropColumn(['student_name', 'user_name', 'package_name']);
        });
    }
};
