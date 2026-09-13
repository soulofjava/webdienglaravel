<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SiteSetting;
use App\Models\VisitorStat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Administrator
        User::updateOrCreate(
            ['email' => 'admin@tiketdieng.com'],
            [
                'name' => 'Administrator TiketDieng',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Pengaturan Default Situs
        SiteSetting::getSettings();

        // 3. Statistik Pengunjung Awal
        $today = Carbon::today()->toDateString();
        VisitorStat::updateOrCreate(
            ['date' => $today],
            [
                'total_visits' => 1284,
                'unique_visitors' => 452,
            ]
        );

        // Data 6 hari sebelumnya untuk grafik / agregasi
        for ($i = 1; $i <= 6; $i++) {
            $pastDate = Carbon::today()->subDays($i)->toDateString();
            VisitorStat::updateOrCreate(
                ['date' => $pastDate],
                [
                    'total_visits' => rand(850, 1600),
                    'unique_visitors' => rand(300, 750),
                ]
            );
        }
    }
}
