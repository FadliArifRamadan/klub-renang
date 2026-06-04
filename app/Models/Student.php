<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'name', 'birth_date', 'gender', 'package_id', 'location_id', 'coach_id', 'quota_left', 'status', 'package_activated_at', 'package_expires_at', 'suspended_at', 'suspension_reason'])]
class Student extends Model
{
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'package_activated_at' => 'datetime',
            'package_expires_at' => 'datetime',
            'suspended_at' => 'datetime',
        ];
    }

    // Relasi ke tabel Packages (Satu murid mengambil satu paket)
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    // Relasi ke tabel Users/Coach (Satu murid dibimbing satu Coach)
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    // Relasi ke tabel Locations (Satu murid berlatih di satu lokasi)
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    // Relasi ke tabel Payments (Satu murid bisa memiliki beberapa pembayaran histori)
    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    // Relasi ke tabel Attendances (Satu murid bisa memiliki beberapa absensi)
    public function attendances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    // Relasi ke tabel ProgressReports (Satu murid bisa memiliki beberapa laporan perkembangan)
    public function progressReports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProgressReport::class, 'student_id');
    }

    // Relasi ke data pembayaran terakhir (untuk check status bayar tercepat)
    public function latestPayment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Payment::class, 'student_id')->latestOfMany();
    }

    // Accessor untuk label teks Gender
    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'L' || $this->gender === 'Laki-laki' ? 'Laki-laki' : 'Perempuan';
    }

    /**
     * Otomatis menonaktifkan murid yang masa berlaku paketnya sudah lewat (kedaluwarsa/hangus)
     * atau kuota sesi latihan sudah habis (quota_left <= 0)
     */
    public static function checkAndExpirePackages()
    {
        // 1. Cek masa berlaku paket kedaluwarsa
        self::where('status', 'active')
            ->whereNotNull('package_expires_at')
            ->where('package_expires_at', '<', now())
            ->update(['status' => 'inactive']);

        // 2. Cek kuota sesi habis
        self::where('status', 'active')
            ->where('quota_left', '<=', 0)
            ->update(['status' => 'inactive']);
    }

    /**
     * Membekukan paket murid (karena sakit / ijin)
     */
    public function suspend(string $reason)
    {
        $this->update([
            'status' => 'suspended',
            'suspended_at' => now(),
            'suspension_reason' => $reason,
        ]);
    }

    /**
     * Mengaktifkan kembali paket murid yang dibekukan, memperpanjang masa aktif, dan menetapkan Coach baru
     */
    public function resume(int $coachId)
    {
        $daysSuspended = 0;
        if ($this->suspended_at) {
            $daysSuspended = now()->diffInDays($this->suspended_at);
        }

        $expiresAt = $this->package_expires_at;
        if ($expiresAt) {
            // Perpanjang tanggal kedaluwarsa sebanyak hari tidak aktif/suspended
            $expiresAt = $expiresAt->addDays($daysSuspended);
        }

        $this->update([
            'status' => 'active',
            'coach_id' => $coachId,
            'suspended_at' => null,
            'suspension_reason' => null,
            'package_expires_at' => $expiresAt,
        ]);
    }
}
