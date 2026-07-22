<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['coach_leave_id', 'student_id', 'schedule_id', 'swimming_class_id', 'original_date', 'status', 'rescheduled_date', 'rescheduled_schedule_id', 'rescheduled_by', 'notes'])]
class RescheduleQueue extends Model
{
    protected function casts(): array
    {
        return [
            'original_date' => 'date',
            'rescheduled_date' => 'date',
        ];
    }

    public function coachLeave(): BelongsTo
    {
        return $this->belongsTo(CoachLeave::class, 'coach_leave_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function swimmingClass(): BelongsTo
    {
        return $this->belongsTo(SwimmingClass::class, 'swimming_class_id');
    }

    public function rescheduledSchedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'rescheduled_schedule_id');
    }

    public function rescheduledByAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rescheduled_by');
    }
}
