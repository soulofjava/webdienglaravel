<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DestinationStory extends Model
{
    protected $table = 'destination_stories';

    protected $fillable = [
        'site_scope',
        'chapter_badge',
        'title',
        'quote',
        'description',
        'highlights',
        'image_url',
        'accent_color',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'highlights' => 'array',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            self::clearStoryCache();
        });

        static::deleted(function () {
            self::clearStoryCache();
        });
    }

    public static function clearStoryCache(): void
    {
        Cache::forget('home_destination_stories');
    }

    /**
     * Dapatkan class Tailwind yang sudah terkompilasi aman untuk styling badge, icon, dan checkmark
     */
    public function getAccentClassesAttribute(): array
    {
        return match ($this->accent_color) {
            'emerald' => [
                'badge' => 'bg-emerald-50 border-emerald-200/60 text-emerald-700',
                'icon' => 'text-emerald-500',
                'check' => 'text-emerald-500',
                'ring' => 'focus:ring-emerald-500/20 focus:border-emerald-500',
                'label' => 'Emerald (Hijau Zamrud)',
            ],
            'indigo' => [
                'badge' => 'bg-indigo-50 border-indigo-200/60 text-indigo-700',
                'icon' => 'text-indigo-600',
                'check' => 'text-indigo-600',
                'ring' => 'focus:ring-indigo-500/20 focus:border-indigo-500',
                'label' => 'Indigo (Lembah Suci)',
            ],
            'blue' => [
                'badge' => 'bg-blue-50 border-blue-200/60 text-[#0064D2]',
                'icon' => 'text-[#0064D2]',
                'check' => 'text-[#0064D2]',
                'ring' => 'focus:ring-blue-500/20 focus:border-blue-500',
                'label' => 'Blue (Tiket Blue / Petualangan)',
            ],
            'rose' => [
                'badge' => 'bg-rose-50 border-rose-200/60 text-rose-700',
                'icon' => 'text-rose-500',
                'check' => 'text-rose-500',
                'ring' => 'focus:ring-rose-500/20 focus:border-rose-500',
                'label' => 'Rose (Merah Fajar)',
            ],
            'purple' => [
                'badge' => 'bg-purple-50 border-purple-200/60 text-purple-700',
                'icon' => 'text-purple-600',
                'check' => 'text-purple-600',
                'ring' => 'focus:ring-purple-500/20 focus:border-purple-500',
                'label' => 'Purple (Mistis Kayangan)',
            ],
            default => [ // amber
                'badge' => 'bg-amber-50 border-amber-200/60 text-amber-700',
                'icon' => 'text-amber-500',
                'check' => 'text-amber-500',
                'ring' => 'focus:ring-amber-500/20 focus:border-amber-500',
                'label' => 'Amber (Emas Matahari)',
            ],
        };
    }

    /**
     * Dapatkan nama icon Lucide fallback jika kosong
     */
    public function getResolvedIconAttribute(): string
    {
        if (!empty($this->icon)) {
            return $this->icon;
        }

        return match ($this->accent_color) {
            'emerald' => 'droplets',
            'indigo' => 'landmark',
            'blue' => 'compass',
            default => 'sunrise',
        };
    }
}
