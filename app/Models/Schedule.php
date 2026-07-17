<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['swimming_class_id', 'location_id', 'day_of_week', 'start_time', 'end_time', 'session_type', 'coach_id', 'is_active', 'notes'])]
class Schedule extends Model
{
    // Relasi ke Coach/Pelatih
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
    // Relasi ke SwimmingClass (Jadwal terikat ke satu kelas)
    public function swimmingClass(): BelongsTo
    {
        return $this->belongsTo(SwimmingClass::class, 'swimming_class_id');
    }

    // Relasi ke Location (Jadwal diadakan di satu lokasi)
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // Relasi ke Students (Jadwal diambil oleh banyak murid)
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_schedules', 'schedule_id', 'student_id')
                    ->withTimestamps();
    }

    // Accessor untuk nama hari dalam Bahasa Indonesia
    public function getDayNameAttribute(): string
    {
        $days = [
            0 => 'Senin',
            1 => 'Selasa',
            2 => 'Rabu',
            3 => 'Kamis',
            4 => 'Jumat',
            5 => 'Sabtu',
            6 => 'Minggu',
        ];

        return $days[$this->day_of_week] ?? 'Hari Tidak Valid';
    }

    // Helper untuk format jam mulai & selesai
    public function getTimeRangeAttribute(): string
    {
        return substr($this->start_time, 0, 5) . ' - ' . substr($this->end_time, 0, 5);
    }

    // Hitung jumlah murid terdaftar (active/pending) di jadwal ini
    public function getCurrentEnrolledCount(): int
    {
        return $this->students()
            ->whereIn('students.status', ['active', 'pending'])
            ->count();
    }

    // Tentukan kapasitas maksimal berdasarkan kategori kelas dan paket
    public function getCapacityLimitForPackage($package): int
    {
        // 1. Cek Kategori Kelas Prestasi
        if ($this->swimmingClass && $this->swimmingClass->class_category_id) {
            $category = $this->swimmingClass->category ?? $this->swimmingClass->swimmingClassCategory ?? null;
            // Jika relasi direct belum di-load, kita cari manual atau gunakan fallback slug
            if ($this->swimmingClass->relationLoaded('category') && $this->swimmingClass->category) {
                if ($this->swimmingClass->category->slug === 'prestasi') {
                    return 15;
                }
            } else {
                // Gunakan query langsung jika diperlukan atau fallback dari relasi category
                $cat = ClassCategory::find($this->swimmingClass->class_category_id);
                if ($cat && $cat->slug === 'prestasi') {
                    return 15;
                }
            }
        }

        if (!$package) {
            return 4; // Default untuk Belajar Reguler
        }

        $type = is_string($package) ? $package : ($package->package_type ?? 'regular');
        $name = is_string($package) ? '' : ($package->name ?? '');

        // 2. Belajar Private & Single Private
        if ($type === 'private' || ($type === 'single_session' && stripos($name, 'private') !== false)) {
            return 1;
        }

        // 3. Belajar Reguler & Single Reguler
        return 4;
    }
}
