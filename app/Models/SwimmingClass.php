<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['class_category_id', 'name', 'progress_form_type', 'age_min', 'age_max', 'max_quota', 'description', 'is_active'])]
class SwimmingClass extends Model
{
    protected $fillable = [
        'class_category_id',
        'name',
        'progress_form_type',
        'age_min',
        'age_max',
        'max_quota',
        'description',
        'is_active',
    ];

    // Relasi ke ClassCategory (Kelas milik satu kategori)
    public function category(): BelongsTo
    {
        return $this->belongsTo(ClassCategory::class, 'class_category_id');
    }

    // Relasi ke Schedules (Kelas memiliki banyak jadwal)
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'swimming_class_id');
    }

    // Relasi ke Packages (Kelas bisa memiliki beberapa penawaran paket)
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'swimming_class_id');
    }

    // Relasi ke Students (Kelas diikuti oleh banyak murid)
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'swimming_class_id');
    }
}
