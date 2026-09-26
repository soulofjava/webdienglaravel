<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PickupLocation extends Model
{
    protected $table = 'pickup_locations';

    protected $fillable = [
        'name',
        'detail',
        'surcharge',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'surcharge' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('api_v1_pickup_locations');
            Cache::forget('home_pickup_locations');
        });

        static::deleted(function () {
            Cache::forget('api_v1_pickup_locations');
            Cache::forget('home_pickup_locations');
        });
    }

    public function getFormattedSurchargeAttribute(): string
    {
        if ($this->surcharge == 0) {
            return 'Bebas Biaya / Standar';
        }
        return '+Rp ' . number_format($this->surcharge, 0, ',', '.') . '/orang';
    }
}
