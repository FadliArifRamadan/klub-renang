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
        // 1. Kategori Kelas (Belajar Renang vs Renang Prestasi)
        Schema::create('class_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 2. Kelas Renang (Batita, Balita, Pra Junior, dll.)
        Schema::create('swimming_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_category_id')->constrained('class_categories')->onDelete('restrict');
            $table->string('name');
            $table->integer('age_min')->default(0);
            $table->integer('age_max')->nullable();
            $table->integer('max_quota')->default(15);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Jadwal Latihan
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('swimming_class_id')->constrained('swimming_classes')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->unsignedTinyInteger('day_of_week'); // 0=Senin ... 6=Minggu
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('session_type', ['swim', 'dryland'])->default('swim');
            $table->boolean('is_active')->default(true);
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        // 4. Jadwal Murid (Many-to-Many Relasi Murid dengan Jadwal)
        Schema::create('student_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->date('enrolled_at')->nullable();
            $table->timestamps();
        });

        // 5. Harga Paket Berdasarkan Lokasi (Untuk Belajar Renang)
        Schema::create('package_location_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_location_prices');
        Schema::dropIfExists('student_schedules');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('swimming_classes');
        Schema::dropIfExists('class_categories');
    }
};
