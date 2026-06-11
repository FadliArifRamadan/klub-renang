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
        // 1. Modifikasi tabel packages
        Schema::table('packages', function (Blueprint $table) {
            $table->foreignId('swimming_class_id')->nullable()->after('id')->constrained('swimming_classes')->onDelete('restrict');
            $table->enum('package_type', ['regular', 'private', 'single_session', 'monthly_prestasi'])->default('regular')->after('swimming_class_id');
            $table->integer('swim_sessions')->nullable()->after('sessions');
            $table->integer('dryland_sessions')->nullable()->after('swim_sessions');
            $table->boolean('is_location_based')->default(false)->after('active_period_months');
            $table->integer('price')->nullable()->change();
        });

        // 2. Modifikasi tabel students
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('swimming_class_id')->nullable()->after('package_id')->constrained('swimming_classes')->onDelete('restrict');
            $table->boolean('registration_fee_paid')->default(false)->after('quota_left');
            $table->foreignId('secondary_location_id')->nullable()->after('location_id')->constrained('locations')->onDelete('set null');
        });

        // 3. Modifikasi tabel progress_reports
        Schema::table('progress_reports', function (Blueprint $table) {
            $table->enum('report_type', ['structured', 'freetext'])->default('freetext')->after('coach_id');
            $table->integer('strength')->nullable()->change();
            $table->integer('endurance')->nullable()->change();
            $table->integer('flexibility')->nullable()->change();
            $table->integer('speed')->nullable()->change();
            $table->integer('agility')->nullable()->change();
        });

        // 4. Modifikasi tabel attendances
        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('session_type', ['swim', 'dryland'])->default('swim')->after('location_id');
        });

        // 5. Modifikasi tabel payments
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_type', ['registration_fee', 'package', 'monthly_prestasi'])->default('package')->after('student_id');
            $table->date('billing_month')->nullable()->after('receipt_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'billing_month']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('session_type');
        });

        Schema::table('progress_reports', function (Blueprint $table) {
            $table->dropColumn('report_type');
            $table->integer('strength')->nullable(false)->change();
            $table->integer('endurance')->nullable(false)->change();
            $table->integer('flexibility')->nullable(false)->change();
            $table->integer('speed')->nullable(false)->change();
            $table->integer('agility')->nullable(false)->change();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['swimming_class_id']);
            $table->dropForeign(['secondary_location_id']);
            $table->dropColumn(['swimming_class_id', 'registration_fee_paid', 'secondary_location_id']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropForeign(['swimming_class_id']);
            $table->dropColumn(['swimming_class_id', 'package_type', 'swim_sessions', 'dryland_sessions', 'is_location_based']);
            $table->integer('price')->nullable(false)->change();
        });
    }
};
