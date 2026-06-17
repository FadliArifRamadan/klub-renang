<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_change_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pembuat request
            $table->json('old_schedule_ids')->nullable(); // Simpan array ID jadwal lama untuk audit
            $table->json('new_schedule_ids'); // Simpan array ID jadwal baru yang diajukan
            $table->text('reason'); // Alasan user
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable(); // Alasan jika ditolak
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null'); // Admin pemroses
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_change_requests');
    }
};
