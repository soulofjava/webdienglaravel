<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

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
        ];
    }

    /**
     * Cek apakah user adalah Superadmin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('superadmin');
    }

    /**
     * Dapatkan scope sub-web untuk pengelola (null jika superadmin)
     */
    public function getSiteScope(): ?string
    {
        if ($this->isSuperAdmin()) {
            return null;
        }

        $email = strtolower($this->email);
        if (str_contains($email, 'lotus')) {
            return 'lotus';
        }
        if (str_contains($email, 'jeep')) {
            return 'jeep';
        }
        if (str_contains($email, 'shuttle')) {
            return 'shuttle';
        }

        return 'tiketdieng';
    }

    /**
     * Cek apakah user berhak mengelola postingan paket tertentu
     */
    public function canManagePackage(TourPackage $package): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $scope = $this->getSiteScope();
        if ($scope === 'lotus') {
            return $package->category === 'Dokumentasi';
        }

        if ($scope === 'tiketdieng') {
            return $package->category !== 'Dokumentasi';
        }

        return true;
    }

    /**
     * Cek apakah user berhak mengelola konfigurasi sub-web tertentu
     */
    public function canManageSite(string $siteKey): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->getSiteScope() === $siteKey;
    }
}
