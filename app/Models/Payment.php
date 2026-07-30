<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['student_id', 'student_name', 'user_name', 'package_name', 'payment_type', 'amount', 'receipt_path', 'billing_month', 'status'])]
class Payment extends Model
{
    protected function casts(): array
    {
        return [
            'billing_month' => 'date',
        ];
    }

    // Hubungan ke data anak yang dibayar
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
