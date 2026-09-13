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
        'whatsapp_number',
        'phone_number',
        'email',
        'address',
        'legal_nib',
        'hpi_badge',
        'favicon_url',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image_url',
    ];

    public static function getSettings(): self
    {
        $attributes = \Illuminate\Support\Facades\Cache::rememberForever('site_settings_attributes', function () {
            $model = self::firstOrCreate(
                ['id' => 'default'],
                [
                    'site_name' => 'TIKETDIENG.COM',
                    'site_tagline' => 'Biro Wisata Dataran Tinggi Dieng',
                    'whatsapp_number' => '62816675404',
                    'phone_number' => '+62 816-675-404',
                    'email' => 'halo@tiketdieng.com',
                    'address' => 'Jl. Dieng Km. 03, Tieng, Kejajar, Wonosobo, Jawa Tengah 56354',
                    'legal_nib' => 'NIB: 1294801928472',
                    'hpi_badge' => 'Anggota Resmi HPI Dieng',
                    'favicon_url' => '/favicon.ico',
                    'seo_title' => 'TiketDieng.com — Paket Wisata Dieng & Biro Perjalanan Resmi',
                    'seo_description' => 'Biro perjalanan wisata resmi Dataran Tinggi Dieng. Nikmati keindahan Golden Sunrise Sikunir, Kawah Sikidang, Telaga Warna, Candi Arjuna, dan Jeep Offroad Safari dengan kenyamanan armada eksekutif.',
                    'seo_keywords' => 'paket wisata dieng, tiket dieng, tour dieng, biro wisata dieng, sunrise sikunir, open trip dieng, sewa jeep dieng, travel dieng',
                    'og_image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop',
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
