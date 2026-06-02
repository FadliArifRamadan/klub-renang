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
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('coach_id')->constrained('users')->onDelete('cascade');
            $table->date('date');
            $table->integer('strength');      // Nilai kekuatan (1-100)
            $table->integer('endurance');     // Nilai daya tahan/VO2Max (1-100)
            $table->integer('flexibility');   // Nilai kelenturan (1-100)
            $table->integer('speed');         // Nilai kecepatan (1-100)
            $table->integer('agility');       // Nilai kelincahan (1-100)
            $table->text('notes')->nullable(); // Catatan tambahan coach
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_reports');
    }
};
