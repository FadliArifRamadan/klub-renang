<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['student_id', 'user_id', 'old_schedule_ids', 'new_schedule_ids', 'reason', 'status', 'rejection_reason', 'processed_by', 'processed_at'])]
class ScheduleChangeRequest extends Model
{
    protected function casts(): array
    {
        return [
            'old_schedule_ids' => 'array',
            'new_schedule_ids' => 'array',
            'processed_at' => 'datetime',
        ];
    }

    // Relasi ke Murid
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relasi ke Pengguna (Orang Tua / Umum) yang membuat pengajuan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Admin yang memproses pengajuan
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Accessor untuk mengambil data Schedule lama dari database
    public function getOldSchedulesAttribute()
    {
        $ids = $this->old_schedule_ids;
        if (empty($ids)) {
            return collect();
        }
        return Schedule::whereIn('id', $ids)->with('location')->get();
    }

    // Accessor untuk mengambil data Schedule baru dari database
    public function getNewSchedulesAttribute()
    {
        $ids = $this->new_schedule_ids;
        if (empty($ids)) {
            return collect();
        }
        return Schedule::whereIn('id', $ids)->with('location')->get();
    }
}
