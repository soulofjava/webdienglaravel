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
