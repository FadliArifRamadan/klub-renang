<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['user_id', 'name', 'birth_date', 'gender', 'package_id', 'swimming_class_id', 'location_id', 'secondary_location_id', 'coach_id', 'quota_left', 'registration_fee_paid', 'status', 'package_activated_at', 'package_expires_at', 'became_inactive_at', 'suspended_at', 'suspension_reason'])]
class Student extends Model
{
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'package_activated_at' => 'datetime',
            'package_expires_at' => 'datetime',
            'became_inactive_at' => 'datetime',
            'suspended_at' => 'datetime',
        ];
    }

    // Relasi ke tabel Packages (Satu murid mengambil satu paket)
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    // Relasi ke SwimmingClass (Satu murid mengikuti satu kelas renang)
    public function swimmingClass(): BelongsTo
    {
        return $this->belongsTo(SwimmingClass::class, 'swimming_class_id');
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

    // Relasi ke tabel Locations untuk lokasi kedua (jika ada)
    public function secondaryLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'secondary_location_id');
    }

    // Relasi ke tabel Schedules (Jadwal murid)
    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'student_schedules', 'student_id', 'schedule_id')
                    ->withTimestamps();
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

    // Relasi ke data pengajuan pindah jadwal
    public function scheduleChangeRequests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ScheduleChangeRequest::class, 'student_id');
    }

    // Accessor untuk label teks Gender
    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'L' || $this->gender === 'Laki-laki' ? 'Laki-laki' : 'Perempuan';
    }

    /**
     * Otomatis menonaktifkan murid yang masa berlaku paketnya sudah lewat (kedaluwarsa/hangus)
     * atau kuota sesi latihan sudah habis (quota_left <= 0).
     * Juga mencatat kapan murid menjadi inactive (untuk aturan biaya daftar ulang 3 bulan).
     */
    public static function checkAndExpirePackages()
    {
        // 1. Cek masa berlaku paket kedaluwarsa
        self::where('status', 'active')
            ->whereNotNull('package_expires_at')
            ->where('package_expires_at', '<', now())
            ->update([
                'status' => 'inactive',
                'became_inactive_at' => now(),
            ]);

        // 2. Cek kuota sesi habis
        self::where('status', 'active')
            ->where('quota_left', '<=', 0)
            ->update([
                'status' => 'inactive',
                'became_inactive_at' => now(),
            ]);
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

    /**
     * Menentukan apakah murid harus membayar biaya pendaftaran Rp 30.000.
     *
     * Aturan:
     * - Pendaftaran pertama kali → BAYAR
     * - Daftar ulang dalam ≤ 3 bulan setelah inactive → GRATIS
     * - Daftar ulang setelah > 3 bulan inactive → BAYAR lagi
     */
    public function shouldPayRegistrationFee(): bool
    {
        // Biaya pendaftaran hanya berlaku untuk kategori 'belajar'
        $swimmingClass = $this->swimmingClass;
        if ($swimmingClass) {
            $category = $swimmingClass->category;
            if ($category && $category->slug !== 'belajar') {
                return false;
            }
        }

        // Belum pernah bayar = pendaftaran pertama → harus bayar
        if (!$this->registration_fee_paid) {
            return true;
        }

        // Sudah pernah bayar, cek apakah sudah > 3 bulan sejak inactive
        if ($this->became_inactive_at) {
            return $this->became_inactive_at->diffInMonths(now()) >= 3;
        }

        // Masih aktif atau baru saja inactive → tidak perlu bayar
        return false;
    }

    /**
     * Menghitung total tagihan untuk pendaftaran/perpanjangan murid saat ini,
     * termasuk harga paket (dinamis berdasarkan lokasi jika tipe belajar)
     * dan biaya pendaftaran Rp 30.000 berdasarkan aturan 3 bulan.
     */
    public function calculateTotalBillingAmount(): int
    {
        $package = $this->package;
        $amount = 0;
        if ($package) {
            $amount = $package->getPriceForLocation($this->location_id);
        }
        if ($this->shouldPayRegistrationFee()) {
            $amount += 30000;
        }
        return $amount;
    }

    /**
     * Get the count of swim attendances recorded for the current active package period.
     */
    public function getSwimAttendancesCountAttribute(): int
    {
        if (!$this->package_activated_at) {
            return 0;
        }

        if ($this->relationLoaded('attendances')) {
            return $this->attendances
                ->where('session_type', 'swim')
                ->where('created_at', '>=', $this->package_activated_at)
                ->count();
        }

        return $this->attendances()
            ->where('session_type', 'swim')
            ->where('created_at', '>=', $this->package_activated_at)
            ->count();
    }

    /**
     * Get the count of dryland attendances recorded for the current active package period.
     */
    public function getDrylandAttendancesCountAttribute(): int
    {
        if (!$this->package_activated_at) {
            return 0;
        }

        if ($this->relationLoaded('attendances')) {
            return $this->attendances
                ->where('session_type', 'dryland')
                ->where('created_at', '>=', $this->package_activated_at)
                ->count();
        }

        return $this->attendances()
            ->where('session_type', 'dryland')
            ->where('created_at', '>=', $this->package_activated_at)
            ->count();
    }

    /**
     * Get remaining swim sessions for the current active package.
     */
    public function getSwimSessionsLeftAttribute(): int
    {
        $package = $this->package;
        if (!$package) return 0;
        
        // Jika paket tidak membatasi sesi renang secara spesifik
        if (is_null($package->swim_sessions)) {
            return $this->quota_left;
        }

        return max(0, $package->swim_sessions - $this->swim_attendances_count);
    }

    /**
     * Get remaining dryland sessions for the current active package.
     */
    public function getDrylandSessionsLeftAttribute(): int
    {
        $package = $this->package;
        if (!$package) return 0;

        // Jika paket tidak membatasi sesi darat secara spesifik (atau diset null)
        // Maka asumsikan paket tersebut murni kelas renang tanpa sesi darat.
        if (is_null($package->dryland_sessions)) {
            return 0; 
        }

        return max(0, $package->dryland_sessions - $this->dryland_attendances_count);
    }
}
