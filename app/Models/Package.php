<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'swimming_class_id', 'package_type', 'price', 'sessions', 'swim_sessions', 'dryland_sessions', 'active_period_months', 'is_location_based'])]
class Package extends Model
{
    // Relasi ke SwimmingClass
    public function swimmingClass(): BelongsTo
    {
        return $this->belongsTo(SwimmingClass::class, 'swimming_class_id');
    }

    // Relasi ke tabel detail harga lokasi
    public function locationPrices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PackageLocationPrice::class, 'package_id');
    }

    // Helper untuk mendapatkan harga berdasarkan lokasi
    public function getPriceForLocation($locationId): int
    {
        if ($this->is_location_based) {
            $locationPrice = $this->locationPrices()->where('location_id', $locationId)->first();
            return $locationPrice ? $locationPrice->price : 0;
        }

        return $this->price ?? 0;
    }
}

