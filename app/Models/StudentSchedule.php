<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['student_id', 'schedule_id', 'enrolled_at'])]
class StudentSchedule extends Model
{
    protected function casts(): array
    {
        return [
            'enrolled_at' => 'date',
        ];
    }

    // Relasi ke Student
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relasi ke Schedule
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
