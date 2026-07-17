<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['coach_id', 'leave_date', 'reason', 'status', 'substitute_coach_id', 'rejection_reason'])]
class CoachLeave extends Model
{
    protected $casts = [
        'leave_date' => 'date',
    ];

    // Relasi ke Coach yang izin
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    // Relasi ke Pelatih Pengganti (Substitute Coach)
    public function substituteCoach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'substitute_coach_id');
    }
}
