<?php

namespace Database\Seeders;

use App\Models\Comcode;
use Illuminate\Database\Seeder;

class ComcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codes = [
            // 1. Kategori Paket Tour Resmi Klien 2026
            [
                'code_group' => 'package_category',
                'code_value' => 'Jeep Tour',
                'code_name' => 'Jeep Tour Dieng',
                'description' => 'Paket jip offroad & wisata alam Dieng rute 1 sampai 5',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_category',
                'code_value' => 'Sunrise Tour',
                'code_name' => 'Sunrise Tour Sikunir',
                'description' => 'Paket berburu fajar emas Bukit Sikunir 2.463 mdpl',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_category',
                'code_value' => 'Shuttle Mikrobus',
                'code_name' => 'Shuttle Mikrobus Dieng',
                'description' => 'Layanan transportasi rombongan shuttle mikrobus rute 1 sampai 5',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_category',
                'code_value' => 'Dokumentasi',
                'code_name' => 'Dokumentasi Drone & Kamera',
                'description' => 'Jasa video sinematik, foto mirrorless, dan aerial drone 4K',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_category',
                'code_value' => 'Tour Guide',
                'code_name' => 'Tour Guide Resmi HPI',
                'description' => 'Pemandu wisata bersertifikasi HPI Wonosobo',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_category',
                'code_value' => 'Outbound & Gathering',
                'code_name' => 'Outbound & Gathering',
                'description' => 'Fun games, capacity building, dan outbound kurikulum Dieng',
                'sort_order' => 6,
                'is_active' => true,
            ],

            // 2. Label Badge Penjualan (Highlight Card)
            [
                'code_group' => 'package_badge',
                'code_value' => 'Best Seller',
                'code_name' => 'Best Seller',
                'description' => 'Paket paling banyak dipesan wisatawan',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_badge',
                'code_value' => 'VIP Exclusive',
                'code_name' => 'VIP Exclusive',
                'description' => 'Layanan premium dengan fasilitas lengkap',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_badge',
                'code_value' => 'Paling Populer',
                'code_name' => 'Paling Populer',
                'description' => 'Paket terfavorit di kalangan rombongan dan keluarga',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_badge',
                'code_value' => 'Hemat Rombongan',
                'code_name' => 'Hemat Rombongan',
                'description' => 'Cocok untuk rombongan instansi, sekolah, atau gathering',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_badge',
                'code_value' => 'Rekomendasi Sunrise',
                'code_name' => 'Rekomendasi Sunrise',
                'description' => 'Rute terbaik untuk melihat matahari terbit',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_badge',
                'code_value' => 'Promo Liburan',
                'code_name' => 'Promo Liburan',
                'description' => 'Penawaran harga spesial periode liburan',
                'sort_order' => 6,
                'is_active' => true,
            ],

            // 3. Durasi Program Standar
            [
                'code_group' => 'package_duration',
                'code_value' => '1 Hari Penuh (03:00 - 17:00 WIB)',
                'code_name' => '1 Hari Penuh (03:00 - 17:00 WIB)',
                'description' => 'Trip intensif dari fajar hingga sore',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_duration',
                'code_value' => 'Sunrise Spesial (03:00 - 11:30 WIB)',
                'code_name' => 'Sunrise Spesial (03:00 - 11:30 WIB)',
                'description' => 'Khusus trip fajar hingga siang',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_duration',
                'code_value' => 'Half Day Tour (08:00 - 15:00 WIB)',
                'code_name' => 'Half Day Tour (08:00 - 15:00 WIB)',
                'description' => 'Trip siang santai tanpa bangun subuh',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_duration',
                'code_value' => '2 Hari 1 Malam (2D1N)',
                'code_name' => '2 Hari 1 Malam (2D1N)',
                'description' => 'Termasuk menginap 1 malam di Dieng/Wonosobo',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_duration',
                'code_value' => '3 Hari 2 Malam (3D2N)',
                'code_name' => '3 Hari 2 Malam (3D2N)',
                'description' => 'Eksplorasi mendalam seluruh objek wisata Dieng',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'code_group' => 'package_duration',
                'code_value' => 'Fleksibel (Sesuai Permintaan)',
                'code_name' => 'Fleksibel (Sesuai Permintaan)',
                'description' => 'Jadwal menyesuaikan kebutuhan tamu',
                'sort_order' => 6,
                'is_active' => true,
            ],

            // 4. Titik Penjemputan Standar (Pickup Areas)
            [
                'code_group' => 'pickup_area',
                'code_value' => 'Wonosobo (Basecamp / Hotel / Terminal Mendolo)',
                'code_name' => 'Wonosobo (Basecamp / Hotel / Terminal Mendolo)',
                'description' => 'Titik kumpul utama di wilayah Wonosobo',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'code_group' => 'pickup_area',
                'code_value' => 'Purwokerto (Stasiun Kereta Api Purwokerto)',
                'code_name' => 'Purwokerto (Stasiun Kereta Api Purwokerto)',
                'description' => 'Penjemputan kedatangan kereta api lintas selatan/barat',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'code_group' => 'pickup_area',
                'code_value' => 'Yogyakarta (Bandara YIA / Stasiun Tugu / Hotel)',
                'code_name' => 'Yogyakarta (Bandara YIA / Stasiun Tugu / Hotel)',
                'description' => 'Penjemputan dari wilayah DIY Yogyakarta',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'code_group' => 'pickup_area',
                'code_value' => 'Semarang (Bandara Ahmad Yani / Stasiun Tawang)',
                'code_name' => 'Semarang (Bandara Ahmad Yani / Stasiun Tawang)',
                'description' => 'Penjemputan dari ibukota Jawa Tengah',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'code_group' => 'pickup_area',
                'code_value' => 'Solo (Bandara Adi Soemarmo / Stasiun Solo Balapan)',
                'code_name' => 'Solo (Bandara Adi Soemarmo / Stasiun Solo Balapan)',
                'description' => 'Penjemputan dari wilayah Surakarta / Solo',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'code_group' => 'pickup_area',
                'code_value' => 'Dieng Plateau (Area Penginapan / Homestay Dieng)',
                'code_name' => 'Dieng Plateau (Area Penginapan / Homestay Dieng)',
                'description' => 'Khusus tamu yang sudah tiba langsung di Dieng',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($codes as $item) {
            Comcode::updateOrCreate(
                [
                    'code_group' => $item['code_group'],
                    'code_value' => $item['code_value'],
                ],
                $item
            );
        }
    }
}
