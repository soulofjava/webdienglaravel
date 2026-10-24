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
        $response->assertSee('Live Pratinjau Tampilan Beranda');
        $response->assertSee('Headline Hero');
        $response->assertSee('4 Poin Keunggulan (Trust Badges)');
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

    public function test_frontend_hero_renders_dynamic_texts(): void
    {
        SiteSetting::updateOrCreate(
            ['id' => 'tiketdieng'],
            [
                'hero_title' => 'Eksplorasi Keajaiban Dieng Khusus',
                'hero_title_accent' => 'Fajar Emas Mempesona',
                'hero_subtitle' => 'Subjudul hero dinamis untuk pengujian.',
                'hero_badge_text' => 'Biro Wisata Terverifikasi',
                'hero_feature_1' => 'Fitur Unggulan Satu',
                'hero_feature_2' => 'Fitur Unggulan Dua',
                'hero_feature_3' => 'Fitur Unggulan Tiga',
                'hero_feature_4' => 'Fitur Unggulan Empat',
            ]
        );
        SiteSetting::clearCache('tiketdieng');

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Eksplorasi Keajaiban Dieng Khusus');
        $response->assertSee('Fajar Emas Mempesona');
        $response->assertSee('Subjudul hero dinamis untuk pengujian.');
        $response->assertSee('Biro Wisata Terverifikasi');
        $response->assertSee('Fitur Unggulan Satu');
        $response->assertSee('Fitur Unggulan Dua');
        $response->assertSee('Fitur Unggulan Tiga');
        $response->assertSee('Fitur Unggulan Empat');
    }
}
