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
        Schema::table('students', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom 'name'
            $table->date('birth_date')->nullable()->after('name');
            $table->enum('gender', ['L', 'P'])->nullable()->after('birth_date');

            // Menambahkan kolom foreign key relasi setelah gender
            $table->foreignId('package_id')->nullable()->after('gender')->constrained('packages')->onDelete('restrict');
            $table->foreignId('location_id')->nullable()->after('package_id')->constrained('locations')->onDelete('restrict');
            $table->foreignId('coach_id')->nullable()->after('location_id')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop foreign key terlebih dahulu
            $table->dropForeign(['package_id']);
            $table->dropForeign(['location_id']);
            $table->dropForeign(['coach_id']);

            // Drop kolomnya
            $table->dropColumn(['birth_date', 'gender', 'package_id', 'location_id', 'coach_id']);
        });
    }
};
