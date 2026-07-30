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
        $this->addIndexIfNotExist('payments', 'status', 'payments_status_index');
        $this->addIndexIfNotExist('payments', 'student_id', 'payments_student_id_index');
        $this->addIndexIfNotExist('payments', 'created_at', 'payments_created_at_index');

        $this->addIndexIfNotExist('attendances', 'date', 'attendances_date_index');
        $this->addIndexIfNotExist('attendances', 'student_id', 'attendances_student_id_index');
        $this->addIndexIfNotExist('attendances', 'coach_id', 'attendances_coach_id_index');

        $this->addIndexIfNotExist('students', 'status', 'students_status_index');
        $this->addIndexIfNotExist('students', 'user_id', 'students_user_id_index');
    }

    private function addIndexIfNotExist(string $table, string $column, string $indexName): void
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
        if (empty($indexes)) {
            Schema::table($table, function (Blueprint $table) use ($column, $indexName) {
                $table->index($column, $indexName);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('payments_status_index');
            $table->dropIndex('payments_student_id_index');
            $table->dropIndex('payments_created_at_index');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex('attendances_date_index');
            $table->dropIndex('attendances_student_id_index');
            $table->dropIndex('attendances_coach_id_index');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex('students_status_index');
            $table->dropIndex('students_user_id_index');
        });
    }
};
