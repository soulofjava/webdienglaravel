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
        'active_theme',
        'company_name',
        'about_us',
        'company_history',
        'company_vision',
        'company_mission',
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
                    'about_us' => 'Tiket Wisata Dieng adalah salah satu vendor lokal dan operator resmi wisata Dieng yang siap membantu Anda dalam menyusun itinerary eksklusif, menghitung simulasi anggaran transparan, dan merealisasikan liburan impian yang aman dan berkesan di Dataran Tinggi Dieng.',
                    'company_history' => 'Tiket Wisata Dieng berdiri sejak tahun 2022 dan berada di bawah naungan resmi induk perusahaan PT. GOtrip Asia Travelindo Wonosobo. Didirikan sebagai unit pemasaran paket tur dan pelayanan terpadu untuk mempermudah reservasi penginapan/homestay, pemandu wisata lokal (HPI), armada shuttle & sewa jeep wisata 4x4, paket konsumsi, hingga petualangan outbound, rafting, dan paralayang di Dieng.',
                    'company_vision' => 'Mempermudah pemesanan akomodasi dan transportasi wisata Dieng dengan aman, transparan, dan terpercaya bagi seluruh wisatawan.',
                    'company_mission' => 'Dengan pembagian tim profesional dari manajemen PT. GOtrip Asia Travelindo Wonosobo, kami berkomitmen untuk meningkatkan kepercayaan klien dan mempermudah dalam merencanakan sampai membantu terealisasinya liburan terbaik Anda ke Dieng.',
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
