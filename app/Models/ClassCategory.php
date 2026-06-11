<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug'])]
class ClassCategory extends Model
{
    // Relasi ke SwimmingClass (Kategori memiliki banyak kelas)
    public function swimmingClasses(): HasMany
    {
        return $this->hasMany(SwimmingClass::class, 'class_category_id');
    }
}
