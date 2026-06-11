<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['swimming_class_id', 'location_id', 'day_of_week', 'start_time', 'end_time', 'session_type', 'is_active', 'notes'])]
class Schedule extends Model
{
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
}
