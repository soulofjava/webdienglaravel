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
     * Dapatkan daftar kategori paket yang menjadi hak kelola user ini.
     * Mengembalikan null jika superadmin (memiliki akses ke seluruh kategori).
     */
    public function getAllowedPackageCategories(): ?array
    {
        $scope = $this->getSiteScope();
        if (!$scope) {
            return null; // Superadmin: bebas kelola semua kategori
        }

        if ($scope === 'lotus') {
            return Comcode::whereIn('code_group', ['package_category', 'category'])
                ->where('site_scope', 'lotus')
                ->pluck('code_value')
                ->push('Dokumentasi')
                ->unique()
                ->values()
                ->toArray();
        }

        if ($scope === 'tiketdieng') {
            // TiketDieng adalah portal induk: boleh seluruh kategori di database KECUALI kategori khusus Lotus
            $lotusCats = Comcode::whereIn('code_group', ['package_category', 'category'])
                ->where('site_scope', 'lotus')
                ->pluck('code_value')
                ->push('Dokumentasi')
                ->unique()
                ->toArray();

            $comcodeCats = Comcode::whereIn('code_group', ['package_category', 'category'])
                ->where(function ($q) {
                    $q->where('site_scope', 'tiketdieng')
                      ->orWhere('site_scope', 'global')
                      ->orWhereNull('site_scope');
                })
                ->pluck('code_value');

            $existingPkgCats = TourPackage::select('category')->distinct()->pluck('category');

            return $comcodeCats->merge($existingPkgCats)
                ->reject(fn($cat) => in_array($cat, $lotusCats, true))
                ->unique()
                ->values()
                ->toArray();
        }

        // Sub-web lain jika ada (misal jeep, shuttle)
        return Comcode::whereIn('code_group', ['package_category', 'category'])
            ->where('site_scope', $scope)
            ->pluck('code_value')
            ->unique()
            ->values()
            ->toArray();
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
            $lotusCategories = Comcode::whereIn('code_group', ['package_category', 'category'])
                ->where('site_scope', 'lotus')
                ->pluck('code_value')
                ->push('Dokumentasi')
                ->unique()
                ->toArray();

            return in_array($package->category, $lotusCategories, true);
        }

        if ($scope === 'tiketdieng') {
            $lotusCategories = Comcode::whereIn('code_group', ['package_category', 'category'])
                ->where('site_scope', 'lotus')
                ->pluck('code_value')
                ->push('Dokumentasi')
                ->unique()
                ->toArray();

            return !in_array($package->category, $lotusCategories, true);
        }

        return false;
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
