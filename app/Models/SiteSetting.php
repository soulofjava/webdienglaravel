<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget('api_v1_site_info');
            Cache::forget("site_settings_{$model->id}");
            self::clearCache($model->id);
        });

        static::deleted(function ($model) {
            Cache::forget('api_v1_site_info');
            Cache::forget("site_settings_{$model->id}");
            self::clearCache($model->id);
        });
    }

    /**
     * Daftar situs sub-unit resmi yang didukung
     */
    public static function supportedSites(): array
    {
        return [
            'tiketdieng' => [
                'name' => 'Tiket Dieng',
                'badge' => 'Portal Induk',
                'domain' => 'tiketdieng.com',
                'color' => 'amber',
                'icon' => 'globe',
            ],
            'lotus' => [
                'name' => 'Lotus Creative',
                'badge' => 'Creative Studio',
                'domain' => 'lotuscreative.id',
                'color' => 'purple',
                'icon' => 'camera',
            ],
            'jeep' => [
                'name' => 'Jeep Dieng',
                'badge' => 'Adventure 4x4',
                'domain' => 'jeepdieng.com',
                'color' => 'emerald',
                'icon' => 'compass',
            ],
            'shuttle' => [
                'name' => 'Shuttle Dieng',
                'badge' => 'Transportasi',
                'domain' => 'shuttledieng.com',
                'color' => 'sky',
                'icon' => 'bus',
            ],
        ];
    }

    /**
     * Mengambil instance setting dinamis berdasarkan key site ('tiketdieng', 'lotus', 'jeep', 'shuttle').
     * Jika $siteKey bernilai null, maka otomatis mengambil tema aktif global atau fallback ke 'tiketdieng'.
     */
    public static function getSettings(?string $siteKey = null): self
    {
        $resolvedKey = self::normalizeSiteKey($siteKey);

        $cacheKey = "site_settings_{$resolvedKey}";

        $attributes = Cache::rememberForever($cacheKey, function () use ($resolvedKey) {
            // Cek apakah data row untuk site ini sudah ada di database
            $record = self::find($resolvedKey);

            if (!$record) {
                // Jika mencari 'tiketdieng' dan ada record 'default' lama, duplikasi/migrasi dari 'default'
                if ($resolvedKey === 'tiketdieng') {
                    $defaultOld = self::find('default');
                    if ($defaultOld) {
                        $record = self::create(array_merge($defaultOld->toArray(), ['id' => 'tiketdieng']));
                    }
                }
            }

            // Jika masih belum ada, buat row baru dengan konfigurasi bawaan khusus sub-web tersebut
            if (!$record) {
                $defaults = self::getDefaultConfig($resolvedKey);
                $record = self::create(array_merge($defaults, ['id' => $resolvedKey]));
            }

            return $record->getAttributes();
        });

        $instance = new self();
        $instance->setRawAttributes($attributes, true);
        $instance->exists = true;
        return $instance;
    }

    /**
     * Normalisasi nama site key agar selalu valid
     */
    public static function normalizeSiteKey(?string $key): string
    {
        $key = strtolower(trim((string) $key));
        if (in_array($key, ['tiketdieng', 'lotus', 'jeep', 'shuttle'])) {
            return $key;
        }

        // Cek request query / domain jika dipanggil dalam konteks web
        if (app()->runningInConsole() === false && request()) {
            if (request()->filled('theme')) {
                $reqTheme = strtolower(trim((string) request()->query('theme')));
                if (in_array($reqTheme, ['tiketdieng', 'lotus', 'jeep', 'shuttle'])) {
                    return $reqTheme;
                }
            }

            $host = strtolower((string) request()->getHost());
            if (str_contains($host, 'lotus') || str_contains($host, 'fotografi')) {
                return 'lotus';
            }
            if (str_contains($host, 'jeep')) {
                return 'jeep';
            }
            if (str_contains($host, 'shuttle')) {
                return 'shuttle';
            }
        }

        // Coba periksa active_theme tersimpan di record default/tiketdieng
        $mainRecord = self::find('tiketdieng') ?: self::find('default');
        if ($mainRecord && in_array($mainRecord->active_theme, ['tiketdieng', 'lotus', 'jeep', 'shuttle'])) {
            return $mainRecord->active_theme;
        }

        return 'tiketdieng';
    }

    /**
     * Accessor favicon dinamis agar sub-web seperti Lotus otomatis memakai favicon ikon tematik
     */
    public function getFaviconUrlAttribute(?string $value): string
    {
        if ($this->id === 'lotus') {
            if (!empty($value) && $value !== '/favicon.png' && $value !== '/favicon.ico') {
                return $value;
            }
            return '/images/favicon-lotus.png';
        }

        if ($this->id === 'jeep') {
            if (!empty($value) && $value !== '/favicon.png' && $value !== '/favicon.ico') {
                return $value;
            }
            return '/images/favicon-jeep.png';
        }

        return $value ?: '/favicon.png';
    }

    /**
     * Konfigurasi profil default per sub-unit bisnis
     */
    public static function getDefaultConfig(string $key): array
    {
        $configs = [
            'tiketdieng' => [
                'site_name' => 'TIKETDIENG.COM',
                'site_tagline' => 'Biro Wisata Dataran Tinggi Dieng & Vendor Resmi',
                'active_theme' => 'tiketdieng',
                'company_name' => 'PT. GOTRIP ASIA TRAVELINDO',
                'about_us' => 'Tiket Wisata Dieng adalah salah satu vendor lokal dan operator resmi wisata Dieng yang siap membantu Anda dalam menyusun itinerary eksklusif, menghitung simulasi anggaran transparan, dan merealisasikan liburan impian yang aman dan berkesan di Dataran Tinggi Dieng.',
                'company_history' => 'Tiket Wisata Dieng berdiri sejak tahun 2022 dan berada di bawah naungan resmi induk perusahaan PT. GOtrip Asia Travelindo Wonosobo. Didirikan sebagai unit pemasaran paket tur dan pelayanan terpadu untuk mempermudah reservasi penginapan/homestay, pemandu wisata lokal (HPI), armada shuttle & sewa jeep wisata 4x4, paket konsumsi, hingga petualangan outbound di Dieng.',
                'company_vision' => 'Mempermudah pemesanan akomodasi dan transportasi wisata Dieng dengan aman, transparan, dan terpercaya bagi seluruh wisatawan.',
                'company_mission' => 'Dengan pembagian tim profesional dari manajemen PT. GOtrip Asia Travelindo Wonosobo, kami berkomitmen untuk meningkatkan kepercayaan klien dan membantu terealisasinya liburan terbaik Anda ke Dieng.',
                'whatsapp_number' => '0816675404',
                'phone_number' => '+62 816-675-404',
                'email' => 'tiket.wisatadieng@gmail.com',
                'address' => 'Jl. Masjid Baitul Nikmah B1, Wonosobo 56351',
                'bank_name' => 'BNI Cabang Wonosobo',
                'bank_account_number' => '8166754042',
                'bank_account_name' => 'PT. GOTRIP ASIA TRAVELINDO',
                'legal_nib' => 'NIB: 1294801928472 (PT. GOTRIP ASIA TRAVELINDO)',
                'hpi_badge' => 'Didukung Vendor & HPI Dieng',
                'favicon_url' => '/favicon.png',
                'seo_title' => 'TiketDieng.com — Paket Wisata Dieng & Biro Perjalanan Resmi',
                'seo_description' => 'Biro perjalanan wisata dan vendor resmi Dataran Tinggi Dieng dari PT. GoTrip Asia Travelindo. Tersedia sewa Jeep Wisata, Shuttle, Homestay, Dokumentasi, dan Outbound.',
                'seo_keywords' => 'paket wisata dieng, tiket dieng, sewa jeep dieng, shuttle dieng, sunrise sikunir, pt gotrip asia travelindo, tiket wisata dieng',
                'og_image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=1200&auto=format&fit=crop',
                'instagram_url' => 'https://www.instagram.com/tiketwisatadieng',
                'tiktok_url' => 'https://tiktok.com/@tiketdieng.com',
                'facebook_url' => 'https://www.facebook.com/share/1Hj4SzNUzH/',
            ],
            'lotus' => [
                'site_name' => 'LOTUS CREATIVE',
                'site_tagline' => 'Cinematic Travel Photography, Video Reels & 4K Drone Dieng',
                'active_theme' => 'lotus',
                'company_name' => 'PT. GOTRIP ASIA TRAVELINDO (Lotus Creative Unit)',
                'about_us' => 'Lotus Creative adalah creative photography & videography studio berbasis di Wonosobo - Dieng Plateau. Kami berspesialisasi dalam dokumentasi liburan estetik, konten reels Instagram & TikTok, visual prewedding, hingga pilot drone profesional 4K.',
                'company_history' => 'Lahir dari kebutuhan wisatawan akan dokumentasi berkualitas sinematik tanpa repot membawa alat berat, Lotus Creative berkembang menjadi studio konten visual perjalanan terdepan di Dataran Tinggi Dieng.',
                'company_vision' => 'Mengabadikan setiap momen magis di Negeri di Atas Awan menjadi karya visual sinematik yang tak lekang oleh waktu.',
                'company_mission' => 'Menghadirkan fotografer dan videografer lokal ramah, profesional, dan menguasai spot foto hidden gems terbaik di Dieng.',
                'whatsapp_number' => '0816675404',
                'phone_number' => '+62 816-675-404',
                'email' => 'halo@lotuscreative.id',
                'address' => 'Jl. Masjid Baitul Nikmah B1, Wonosobo 56351',
                'bank_name' => 'BNI Cabang Wonosobo',
                'bank_account_number' => '8166754042',
                'bank_account_name' => 'PT. GOTRIP ASIA TRAVELINDO',
                'legal_nib' => 'NIB: 1294801928472 (PT. GOTRIP ASIA TRAVELINDO)',
                'hpi_badge' => 'Certified Drone Pilot & Photographer',
                'favicon_url' => '/images/favicon-lotus.png',
                'seo_title' => 'Lotus Creative — Travel Photography, Cinematic Reels & Drone 4K Dieng',
                'seo_description' => 'Layanan dokumentasi foto liburan estetik, video cinematic reels, dan pilot drone 4K di Dataran Tinggi Dieng oleh tim fotografer profesional Lotus Creative.',
                'seo_keywords' => 'lotus creative, foto wisata dieng, jasa foto dieng, sewa drone dieng, video reels dieng, fotografer sikunir, fotografer telaga warna',
                'og_image_url' => 'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=1200&auto=format&fit=crop',
                'instagram_url' => 'https://www.instagram.com/lotuscreative.id',
                'tiktok_url' => 'https://tiktok.com/@lotuscreative.id',
                'facebook_url' => 'https://www.facebook.com/share/1Hj4SzNUzH/',
            ],
            'jeep' => [
                'site_name' => 'READY JEEP DIENG',
                'site_tagline' => 'Sewa Jeep Wisata Offroad 4x4 Dataran Tinggi Dieng (All In)',
                'active_theme' => 'jeep',
                'company_name' => 'PT. GOTRIP ASIA TRAVELINDO (Ready Jeep Dieng)',
                'about_us' => 'Ready Jeep Dieng menyediakan armada sewa mobil Jeep 4x4 tangguh (Daihatsu Feroza & Suzuki Katana) dengan konsep All-In untuk menaklukkan medan ekstrem pegunungan Dieng. Nikmati perjalanan seru berburu sunrise di puncak Bukit Sikunir, menjelajahi kawah vulkanik, savana, dan telaga tersembunyi.',
                'company_history' => 'Didirikan untuk memberikan pengalaman petualangan alam terbuka yang aman dan mendebarkan di dataran tinggi vulkanik Dieng sejak 2022.',
                'company_vision' => 'Menjadi operator penyewaan jeep offroad wisata terpercaya dengan standar keselamatan dan pelayanan terbaik di Jawa Tengah.',
                'company_mission' => 'Menyediakan unit 4x4 prima, driver lokal terlatih dan bersertifikasi, serta rute tour petualangan yang kaya cerita geologi dan budaya.',
                'whatsapp_number' => '081325631952',
                'phone_number' => '+62 813-2563-1952',
                'email' => 'jeep@tiketdieng.com',
                'address' => 'Jl. Dieng Km. 03, Tieng, Kejajar, Wonosobo 56354',
                'bank_name' => 'BNI Cabang Wonosobo',
                'bank_account_number' => '8166754042',
                'bank_account_name' => 'PT. GOTRIP ASIA TRAVELINDO',
                'legal_nib' => 'NIB: 1294801928472 (PT. GOTRIP ASIA TRAVELINDO)',
                'hpi_badge' => 'Paguyuban Driver Jeep Wisata Dieng',
                'favicon_url' => '/images/favicon-jeep.png',
                'seo_title' => 'Ready Jeep Dieng — Sewa Jeep Wisata Offroad 4x4 Dataran Tinggi Dieng (All In)',
                'seo_description' => 'Sewa Ready Jeep Dieng 4x4 resmi All In. Paket sunrise Sikunir, kawah Sikidang, Candi Dieng, Telaga Menjer. Termasuk Jeep, driver, BBM, parkir, tiket masuk & dokumentasi HP.',
                'seo_keywords' => 'ready jeep dieng, jeep dieng, sewa jeep dieng all in, tarif jeep dieng 2026, jeep sikunir, offroad 4x4 dieng',
                'og_image_url' => '/images/ready-jeep-dieng-logo.jpeg',
                'instagram_url' => 'https://www.instagram.com/jeepdiengadventure',
                'tiktok_url' => 'https://tiktok.com/@jeepdieng',
                'facebook_url' => 'https://www.facebook.com/share/1Hj4SzNUzH/',
            ],
            'shuttle' => [
                'site_name' => 'SHUTTLE DIENG',
                'site_tagline' => 'Layanan Transportasi Mikrobus AC & Antar Jemput Stasiun/Bandara Dieng',
                'active_theme' => 'shuttle',
                'company_name' => 'PT. GOTRIP ASIA TRAVELINDO (Transport Service Unit)',
                'about_us' => 'Shuttle Dieng menghadirkan solusi perjalanan darat yang nyaman, tepat waktu, dan terjadwal menghubungkan kota-kota transit utama (Purwokerto, Yogyakarta, Semarang) langsung menuju penginapan Anda di Dataran Tinggi Dieng.',
                'company_history' => 'Unit transportasi resmi PT. GoTrip Asia Travelindo yang melayani ribuan wisatawan nusantara dan mancanegara dengan armada mikrobus 15 penumpang ber-AC sejak 2022.',
                'company_vision' => 'Menghubungkan akses transportasi menuju Dataran Tinggi Dieng secara mudah, terintegrasi, dan terjangkau bagi semua kalangan.',
                'company_mission' => 'Mengutamakan keselamatan berkendara, ketepatan jadwal penjemputan door-to-door, serta kenyamanan kabin berstandar pariwisata.',
                'whatsapp_number' => '0816675404',
                'phone_number' => '+62 816-675-404',
                'email' => 'shuttle@tiketdieng.com',
                'address' => 'Jl. Masjid Baitul Nikmah B1, Wonosobo 56351',
                'bank_name' => 'BNI Cabang Wonosobo',
                'bank_account_number' => '8166754042',
                'bank_account_name' => 'PT. GOTRIP ASIA TRAVELINDO',
                'legal_nib' => 'NIB: 1294801928472 (PT. GOTRIP ASIA TRAVELINDO)',
                'hpi_badge' => 'Izin Angkutan Pariwisata Resmi',
                'favicon_url' => '/favicon.png',
                'seo_title' => 'Shuttle Dieng — Layanan Transportasi & Antar Jemput Wisata Dieng Plateau',
                'seo_description' => 'Layanan shuttle mikrobus antar-jemput resmi Stasiun Purwokerto, Bandara YIA Jogja, dan Semarang ke Dieng. Kursi nyaman AC 15 seat, driver berpengalaman.',
                'seo_keywords' => 'shuttle dieng, antar jemput stasiun purwokerto dieng, travel jogja dieng, travel semarang dieng, sewa hiace dieng',
                'og_image_url' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=1200&auto=format&fit=crop',
                'instagram_url' => 'https://www.instagram.com/shuttledieng',
                'tiktok_url' => 'https://tiktok.com/@shuttledieng',
                'facebook_url' => 'https://www.facebook.com/share/1Hj4SzNUzH/',
            ],
        ];

        return $configs[$key] ?? $configs['tiketdieng'];
    }

    /**
     * Bersihkan cache settings seluruh site
     */
    public static function clearCache(?string $siteKey = null): void
    {
        if ($siteKey) {
            Cache::forget("site_settings_{$siteKey}");
        } else {
            foreach (['tiketdieng', 'lotus', 'jeep', 'shuttle', 'default'] as $k) {
                Cache::forget("site_settings_{$k}");
            }
        }
        Cache::forget('site_settings_attributes');
    }
}
