<?php

namespace Database\Seeders;

use App\Models\PickupLocation;
use Illuminate\Database\Seeder;

class PickupLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Kota Wonosobo / Terminal Mendolo',
                'detail' => 'Basecamp / Hotel / Stasiun Kota Wonosobo (Gratis / Titik Utama)',
                'surcharge' => 0,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Dieng Plateau (Homestay / Basecamp)',
                'detail' => 'Khusus wisatawan yang sudah tiba langsung di kawasan Dieng',
                'surcharge' => 0,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Purwokerto — Stasiun / Terminal',
                'detail' => 'Stasiun Kereta Api Purwokerto / Terminal Bus Bulupitu (+Rp 50.000/org)',
                'surcharge' => 50000,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Yogyakarta — Stasiun Tugu / Bandara YIA',
                'detail' => 'Stasiun Tugu / Lempuyangan / Bandara Internasional YIA / Hotel Jogja (+Rp 100.000/org)',
                'surcharge' => 100000,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Semarang — Stasiun Tawang / Bandara',
                'detail' => 'Stasiun Tawang / Poncol / Bandara Internasional Ahmad Yani (+Rp 100.000/org)',
                'surcharge' => 100000,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Solo / Surakarta — Stasiun Balapan / Bandara',
                'detail' => 'Stasiun Solo Balapan / Bandara Adi Soemarmo / Hotel Solo (+Rp 120.000/org)',
                'surcharge' => 120000,
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($locations as $loc) {
            PickupLocation::updateOrCreate(
                ['name' => $loc['name']],
                $loc
            );
        }
    }
}
