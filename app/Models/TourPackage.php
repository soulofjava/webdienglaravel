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
            \Illuminate\Support\Facades\Cache::forget('home_tour_packages');
            \Illuminate\Support\Facades\Cache::forget('home_doc_packages');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('home_tour_packages');
            \Illuminate\Support\Facades\Cache::forget('home_doc_packages');
        });
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
