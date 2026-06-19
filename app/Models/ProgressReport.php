<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['student_id', 'coach_id', 'report_type', 'date', 'metrics', 'notes'])]
class ProgressReport extends Model
{
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'metrics' => 'array',
        ];
    }

    // Relasi ke Student
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relasi ke Coach
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
