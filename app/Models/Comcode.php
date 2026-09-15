<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Comcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_group',
        'site_scope',
        'code_value',
        'code_name',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Hitung berapa banyak paket wisata yang saat ini menggunakan master kode ini.
     */
    public function countUsedPackages(): int
    {
        $group = $this->code_group;
        $val = $this->code_value;

        if (in_array($group, ['package_category', 'category'])) {
            return TourPackage::where('category', $val)->count();
        }

        if (in_array($group, ['package_badge', 'badge'])) {
            return TourPackage::where('badge', $val)->count();
        }

        if ($group === 'package_duration') {
            return TourPackage::where('duration', $val)->count();
        }

        if ($group === 'pickup_area') {
            return TourPackage::where('pickup_location', $val)->count();
        }

        return 0;
    }

    /**
     * Cek apakah user berwenang mengubah atau menghapus master kode ini.
     * Non-superadmin hanya berhak mengelola master kode milik unitnya sendiri.
     * Kode bertaraf 'global' hanya boleh diubah/dihapus oleh Superadmin.
     */
    public function canManage(User $user): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        $userScope = $user->getSiteScope();

        if ($userScope === 'lotus') {
            return $this->site_scope === 'lotus';
        }

        if ($userScope === 'tiketdieng') {
            return $this->site_scope === 'tiketdieng';
        }

        return !empty($userScope) && $this->site_scope === $userScope;
    }

    /**
     * Ambil daftar kode berdasarkan group (hanya yang aktif, terurut sort_order)
     */
    public static function getGroup(string $group): Collection
    {
        return static::where('code_group', $group)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('code_name', 'asc')
            ->get();
    }

    /**
     * Helper khusus kategori paket wisata
     */
    public static function getCategories(): Collection
    {
        return static::getGroup('package_category');
    }

    /**
     * Helper khusus badge paket wisata
     */
    public static function getBadges(): Collection
    {
        return static::getGroup('package_badge');
    }

    /**
     * Helper khusus durasi tour
     */
    public static function getDurations(): Collection
    {
        return static::getGroup('package_duration');
    }

    /**
     * Helper khusus area titik jemput
     */
    public static function getPickupLocations(): Collection
    {
        return static::getGroup('pickup_area');
    }
}
