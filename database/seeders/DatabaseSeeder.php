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
        // Role & Permissions
        $superRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // 1. Akun Superadmin
        $superadmin = User::updateOrCreate(
            ['email' => 'isamaulanatantra@gmail.com'],
            [
                'name' => 'Isa Maulana Tantra (Superadmin)',
                'password' => Hash::make('superadmin123'),
                'email_verified_at' => now(),
            ]
        );
        $superadmin->syncRoles([$superRole]);

        // 2. Akun Administrator Biasa
        $admin = User::updateOrCreate(
            ['email' => 'admin@tiketdieng.com'],
            [
                'name' => 'Administrator TiketDieng',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->syncRoles([$adminRole]);

        // 2. Pengaturan Default Situs
        SiteSetting::getSettings();

        // 3. Paket Wisata & Itinerary Tour Dieng
        $this->call(TourPackageSeeder::class);

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
