<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['student_id', 'coach_id', 'location_id', 'date'])]
class Attendance extends Model
{
    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    // Relasi ke Student (Murid)
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relasi ke User/Coach
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    // Relasi ke Location (Kolam Latihan)
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
