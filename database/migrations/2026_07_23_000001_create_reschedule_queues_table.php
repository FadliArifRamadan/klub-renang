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
        Schema::create('reschedule_queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_leave_id')->constrained('coach_leaves')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->foreignId('swimming_class_id')->constrained('swimming_classes')->onDelete('cascade');
            $table->date('original_date');
            $table->enum('status', ['pending', 'rescheduled', 'cancelled'])->default('pending');
            $table->date('rescheduled_date')->nullable();
            $table->foreignId('rescheduled_schedule_id')->nullable()->constrained('schedules')->onDelete('set null');
            $table->foreignId('rescheduled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reschedule_queues');
    }
};
