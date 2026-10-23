<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $superadmin;
    protected User $staffAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $this->superadmin = User::firstOrCreate(
            ['email' => 'superadmin@tiketdieng.com'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('password'),
            ]
        );
        $this->superadmin->syncRoles([$superadminRole]);

        $this->staffAdmin = User::firstOrCreate(
            ['email' => 'staff@tiketdieng.com'],
            [
                'name' => 'Staff Admin',
                'password' => bcrypt('password'),
            ]
        );
        $this->staffAdmin->syncRoles([$adminRole]);
    }

    public function test_superadmin_can_render_dashboard_with_all_modular_partials(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang, Super Administrator');
        $response->assertSee('Total Paket');
        $response->assertSee('Total Titik Jemput');
        $response->assertSee('Pengunjung Hari Ini');
        $response->assertSee('Total Master Kode');
        $response->assertSee('Pilih Sub-Web Yang Dikonfigurasi:');
        $response->assertSee('Pengaturan Multi-Situs');
        $response->assertSee('1. Identitas Situs Web');
        $response->assertSee('2. Profil Perusahaan, Visi');
        $response->assertSee('3. Saluran Komunikasi');
        $response->assertSee('4. Alamat Kantor');
        $response->assertSee('5. Optimasi Mesin Pencari');
        $response->assertSee('Simpan Seluruh Pengaturan');
        $response->assertSee('Manajemen Tim Pengelola');
        $response->assertSee('Kembalikan ke Pengaturan Awal');
    }

    public function test_staff_admin_can_render_dashboard(): void
    {
        $response = $this->actingAs($this->staffAdmin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang, Staff Admin');
        $response->assertSee('1. Identitas Situs Web');
        $response->assertSee('Simpan Seluruh Pengaturan');
    }
}
