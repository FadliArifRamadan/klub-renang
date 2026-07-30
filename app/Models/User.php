<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Student;

#[Fillable(['name', 'username', 'phone', 'gender', 'role', 'password', 'image', 'licenses', 'certifications', 'experience'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'licenses' => 'array',
            'certifications' => 'array',
        ];
    }

    public function students()
    {
        // Hubungkan ke model Student menggunakan foreign key 'coach_id' yang ada di tabel students
        return $this->hasMany(Student::class, 'coach_id');
    }

    public function children()
    {
        // Hubungkan ke model Student menggunakan foreign key 'user_id' yang didaftarkan oleh Parent ini
        return $this->hasMany(Student::class, 'user_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'coach_id');
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'admin_finance', 'admin_operasional']);
    }

    public function isAdminFinance(): bool
    {
        return in_array($this->role, ['admin', 'admin_finance']);
    }

    public function isAdminOperasional(): bool
    {
        return in_array($this->role, ['admin', 'admin_operasional']);
    }
}
