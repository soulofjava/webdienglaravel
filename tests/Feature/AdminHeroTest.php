<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminHeroTest extends TestCase
{
    use RefreshDatabase;

    protected User $superadmin;
    protected User $staffAdmin;
    protected User $lotusAdmin;
    protected User $jeepAdmin;

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
                'name' => 'Staff Admin Tiket',
                'password' => bcrypt('password'),
            ]
        );
        $this->staffAdmin->syncRoles([$adminRole]);

        $this->lotusAdmin = User::firstOrCreate(
            ['email' => 'admin.lotus@tiketdieng.com'],
            [
                'name' => 'Admin Lotus Creative',
                'password' => bcrypt('password'),
            ]
        );
        $this->lotusAdmin->syncRoles([$adminRole]);

        $this->jeepAdmin = User::firstOrCreate(
            ['email' => 'admin.jeep@tiketdieng.com'],
            [
                'name' => 'Admin Ready Jeep',
                'password' => bcrypt('password'),
            ]
        );
        $this->jeepAdmin->syncRoles([$adminRole]);
    }

    public function test_guest_cannot_access_hero_management(): void
    {
        $response = $this->get('/admin/hero');
        $response->assertRedirect('/admin/login');
    }

    public function test_superadmin_can_access_hero_editor(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/hero');

        $response->assertStatus(200);
        $response->assertSee('Kustomisasi Hero Banner');
        $response->assertSee('Tiket Dieng');
        $response->assertSee('Lotus Creative');
        $response->assertSee('Jeep Dieng');
    }

    public function test_superadmin_can_update_hero_texts(): void
    {
        $payload = [
            'site_key' => 'tiketdieng',
            'hero_title' => 'Petualangan Spektakuler Dieng Plateau',
            'hero_title_accent' => 'Negeri di Atas Awan 2026',
            'hero_subtitle' => 'Paket wisata premium Dieng dengan layanan privat dan armada nyaman.',
            'hero_badge_text' => 'Biro Terpercaya No. 1',
            'hero_feature_1' => 'Legalitas Lengkap',
            'hero_feature_2' => 'Sunrise Sikunir Terbaik',
            'hero_feature_3' => 'Armada HiAce & Innova VIP',
            'hero_feature_4' => 'Garansi Kepuasan 100%',
        ];

        $response = $this->actingAs($this->superadmin)->post('/admin/hero', $payload);

        $response->assertRedirect('/admin/hero?site=tiketdieng');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', [
            'id' => 'tiketdieng',
            'hero_title' => 'Petualangan Spektakuler Dieng Plateau',
            'hero_title_accent' => 'Negeri di Atas Awan 2026',
            'hero_subtitle' => 'Paket wisata premium Dieng dengan layanan privat dan armada nyaman.',
            'hero_badge_text' => 'Biro Terpercaya No. 1',
            'hero_feature_1' => 'Legalitas Lengkap',
            'hero_feature_2' => 'Sunrise Sikunir Terbaik',
            'hero_feature_3' => 'Armada HiAce & Innova VIP',
            'hero_feature_4' => 'Garansi Kepuasan 100%',
        ]);
    }

    public function test_admin_lotus_scope_is_isolated_and_cannot_manage_other_units(): void
    {
        // Admin Lotus masuk ke /admin/hero -> hanya melihat Lotus Creative
        $response = $this->actingAs($this->lotusAdmin)->get('/admin/hero');

        $response->assertStatus(200);
        $response->assertSee('Lotus Creative');
        // Tidak melihat switcher portal lain
        $response->assertDontSee('Jeep Dieng');

        // Update hero oleh Admin Lotus
        $lotusPayload = [
            'site_key' => 'lotus',
            'hero_title' => 'Visual Sinematik Premium',
            'hero_title_accent' => 'Karya Magis Dieng',
            'hero_subtitle' => 'Jasa dokumentasi foto dan video reels profesional di Dieng.',
            'hero_badge_text' => 'Studio Foto Resmi Dieng',
            'hero_feature_1' => 'Sony Full Frame',
            'hero_feature_2' => 'DJI Drone 4K',
            'hero_feature_3' => 'Cinematic Moody Tone',
            'hero_feature_4' => 'Posing Guide Ramah',
        ];

        $updateResponse = $this->actingAs($this->lotusAdmin)->post('/admin/hero', $lotusPayload);
        $updateResponse->assertRedirect('/admin/hero?site=lotus');

        $this->assertDatabaseHas('site_settings', [
            'id' => 'lotus',
            'hero_title' => 'Visual Sinematik Premium',
            'hero_title_accent' => 'Karya Magis Dieng',
        ]);
    }

    public function test_admin_jeep_scope_is_isolated(): void
    {
        // Admin Jeep masuk ke /admin/hero -> hanya melihat Ready Jeep Dieng
        $response = $this->actingAs($this->jeepAdmin)->get('/admin/hero');

        $response->assertStatus(200);
        $response->assertSee('Ready Jeep Dieng');
        $response->assertDontSee('Lotus Creative');

        // Update hero oleh Admin Jeep
        $jeepPayload = [
            'site_key' => 'jeep',
            'hero_title' => 'Jelajah Alam Ekstrem',
            'hero_title_accent' => 'Jeep 4x4 Dieng All-In',
            'hero_subtitle' => 'Paket sewa jeep wisata Dieng terlengkap tanpa biaya tersembunyi.',
            'hero_badge_text' => 'Unit 4x4 Tangguh Terverifikasi',
            'hero_feature_1' => 'Tiket Wisata Included',
            'hero_feature_2' => 'Kapasitas 4 Penumpang',
            'hero_feature_3' => 'Dokumentasi Gratis',
            'hero_feature_4' => 'Armada Sehat',
        ];

        $updateResponse = $this->actingAs($this->jeepAdmin)->post('/admin/hero', $jeepPayload);
        $updateResponse->assertRedirect('/admin/hero?site=jeep');

        $this->assertDatabaseHas('site_settings', [
            'id' => 'jeep',
            'hero_title' => 'Jelajah Alam Ekstrem',
            'hero_title_accent' => 'Jeep 4x4 Dieng All-In',
        ]);
    }

    public function test_lotus_and_jeep_frontend_render_dynamic_hero(): void
    {
        // Set dynamic content untuk Lotus
        SiteSetting::updateOrCreate(
            ['id' => 'lotus'],
            [
                'hero_title' => 'Abadikan Keajaiban Visual',
                'hero_title_accent' => 'Dieng Estetik 2026',
                'hero_subtitle' => 'Deskripsi khusus Lotus Creative dinamis.',
                'hero_badge_text' => 'Official Lotus Studio Gotrip',
            ]
        );
        SiteSetting::clearCache('lotus');

        $lotusResponse = $this->get('/?theme=lotus');
        $lotusResponse->assertStatus(200);
        $lotusResponse->assertSee('Abadikan Keajaiban Visual');
        $lotusResponse->assertSee('Dieng Estetik 2026');
        $lotusResponse->assertSee('Deskripsi khusus Lotus Creative dinamis.');
        $lotusResponse->assertSee('Official Lotus Studio Gotrip');

        // Set dynamic content untuk Jeep
        SiteSetting::updateOrCreate(
            ['id' => 'jeep'],
            [
                'hero_title' => 'Petualangan Offroad Memacu Adrenalin',
                'hero_title_accent' => 'Ready Jeep 4x4 Paling Seru',
                'hero_subtitle' => 'Deskripsi dinamis khusus sewa jeep Dieng.',
                'hero_badge_text' => 'UNIT RESMI 4X4 JEEP DIENG',
                'hero_feature_1' => 'Tiket Masuk All In Termasuk',
            ]
        );
        SiteSetting::clearCache('jeep');

        $jeepResponse = $this->get('/?theme=jeep');
        $jeepResponse->assertStatus(200);
        $jeepResponse->assertSee('Petualangan Offroad Memacu Adrenalin');
        $jeepResponse->assertSee('Ready Jeep 4x4 Paling Seru');
        $jeepResponse->assertSee('Deskripsi dinamis khusus sewa jeep Dieng.');
        $jeepResponse->assertSee('UNIT RESMI 4X4 JEEP DIENG');
        $jeepResponse->assertSee('Tiket Masuk All In Termasuk');
    }
}
