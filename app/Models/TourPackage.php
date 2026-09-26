<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TourPackage extends Model
{
    protected $table = 'tour_packages';

    protected $fillable = [
        'slug',
        'title',
        'category',
        'duration',
        'pickup_location',
        'price',
        'price_note',
        'badge',
        'image_url',
        'summary',
        'itinerary_options',
        'inclusions',
        'exclusions',
        'preparations',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'itinerary_options' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'preparations' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'integer',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($package) {
            if (empty($package->slug)) {
                $package->slug = Str::slug($package->title) . '-' . Str::random(4);
            }
        });

        static::saved(function () {
            self::clearAllPackageCaches();
        });

        static::deleted(function () {
            self::clearAllPackageCaches();
        });
    }

    /**
     * Mengambil versi timestamp rilis paket saat ini untuk cache-busting
     */
    public static function getVersion(): string
    {
        return (string) \Illuminate\Support\Facades\Cache::rememberForever('api_packages_version', function () {
            $latest = self::max('updated_at');
            return $latest ? (string) strtotime($latest) : (string) time();
        });
    }

    /**
     * Menghapus seluruh cache paket wisata saat Admin melakukan CRUD
     */
    public static function clearAllPackageCaches(): void
    {
        // 1. Naikkan versi cache agar seluruh instance dan edge CDN langsung menganggap cache lama usang
        \Illuminate\Support\Facades\Cache::forever('api_packages_version', (string) time());

        // 2. Bersihkan cache web portal
        \Illuminate\Support\Facades\Cache::forget('home_tour_packages');
        \Illuminate\Support\Facades\Cache::forget('home_doc_packages');
        \Illuminate\Support\Facades\Cache::forget('lotus_doc_packages');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
