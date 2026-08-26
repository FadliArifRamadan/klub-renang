<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'position', 'bio', 'image', 'social_media', 'order', 'is_active'])]
class Founder extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'social_media' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope: hanya founder yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: urut berdasarkan kolom order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
