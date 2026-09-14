<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'site_name',
        'site_tagline',
        'company_name',
        'whatsapp_number',
        'phone_number',
        'email',
        'address',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'legal_nib',
        'hpi_badge',
        'favicon_url',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image_url',
        'instagram_url',
        'tiktok_url',
        'facebook_url',
    ];

    public static function getSettings(): self
    {
        $attributes = \Illuminate\Support\Facades\Cache::rememberForever('site_settings_attributes', function () {
            $model = self::firstOrCreate(
                ['id' => 'default'],
                [
                    'site_name' => 'TIKETDIENG.COM',
                    'site_tagline' => 'Biro Wisata Dataran Tinggi Dieng & Vendor Resmi',
                    'company_name' => 'PT. GOTRIP ASIA TRAVELINDO',
                    'whatsapp_number' => '0816675404',
                    'phone_number' => '+62 816-675-404',
                    'email' => 'tiket.wisatadieng@gmail.com',
                    'address' => 'Jl. Masjid Baitul Nikmah B1, Wonosobo 56351',
                    'bank_name' => 'BNI Cabang Wonosobo',
                    'bank_account_number' => '8166754042',
                    'bank_account_name' => 'PT. GOTRIP ASIA TRAVELINDO',
                    'legal_nib' => 'Legalitas NIB Resmi',
                    'hpi_badge' => 'Didukung Vendor & HPI Dieng',
                    'favicon_url' => '/favicon.png',
                    'seo_title' => 'TiketDieng.com — Paket Wisata Dieng & Biro Perjalanan Resmi',
                    'seo_description' => 'Biro perjalanan wisata dan vendor resmi Dataran Tinggi Dieng dari PT. GoTrip Asia Travelindo. Tersedia sewa Jeep Wisata, Shuttle, Homestay, Dokumentasi, dan Outbound.',
                    'seo_keywords' => 'paket wisata dieng, tiket dieng, sewa jeep dieng, shuttle dieng, sunrise sikunir, pt gotrip asia travelindo, tiket wisata dieng',
                    'og_image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop',
                    'instagram_url' => 'https://www.instagram.com/tiketwisatadieng',
                    'tiktok_url' => 'https://tiktok.com/@tiketdieng.com',
                    'facebook_url' => 'https://www.facebook.com/share/1Hj4SzNUzH/',
                ]
            );
            return $model->getAttributes();
        });

        $instance = new self();
        $instance->setRawAttributes($attributes, true);
        $instance->exists = true;
        return $instance;
    }

    public static function clearCache(): void
    {
        \Illuminate\Support\Facades\Cache::forget('site_settings_attributes');
    }
}
