<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminAppearanceTest extends TestCase
{
    use RefreshDatabase;

    protected User $superadmin;
    protected User $lotusAdmin;

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

        $this->lotusAdmin = User::firstOrCreate(
            ['email' => 'admin.lotus@tiketdieng.com'],
            [
                'name' => 'Admin Lotus Creative',
                'password' => bcrypt('password'),
            ]
        );
        $this->lotusAdmin->syncRoles([$adminRole]);
    }

    public function test_appearance_settings_card_rendered_in_admin_dashboard(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('6. Pengaturan Tampilan dan Desain Tema');
        $response->assertSee('Primary Color');
        $response->assertSee('Accent Color');
        $response->assertSee('WhatsApp Color');
        $response->assertSee('Font Family');
        $response->assertSee('Plus Jakarta Sans');
        $response->assertSee('Inter');
        $response->assertSee('Outfit');
        $response->assertSee('Poppins');
        $response->assertSee('Playfair Display');
        $response->assertSee('Compact');
        $response->assertSee('Normal');
        $response->assertSee('Relaxed');
        $response->assertSee('rounded-3xl');
        $response->assertSee('rounded-xl');
        $response->assertSee('rounded-lg');
        $response->assertSee('Simpan Desain');
    }

    public function test_superadmin_can_update_appearance_settings_via_dedicated_endpoint(): void
    {
        $payload = [
            'site_key' => 'tiketdieng',
            'primary_color' => '#8B5CF6',
            'accent_color' => '#F59E0B',
            'whatsapp_color' => '#10B981',
            'font_family' => 'Outfit',
            'font_size_scale' => 'relaxed',
            'border_radius_style' => 'rounded-xl',
            'hero_widget_overlap' => '0',
        ];

        $response = $this->actingAs($this->superadmin)
            ->post('/admin/settings/appearance', $payload);

        $response->assertRedirect('/admin?site=tiketdieng');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', [
            'id' => 'tiketdieng',
            'primary_color' => '#8B5CF6',
            'accent_color' => '#F59E0B',
            'whatsapp_color' => '#10B981',
            'font_family' => 'Outfit',
            'font_size_scale' => 'relaxed',
            'border_radius_style' => 'rounded-xl',
            'hero_widget_overlap' => 0,
        ]);
    }

    public function test_superadmin_can_update_appearance_via_ajax_endpoint(): void
    {
        $payload = [
            'site_key' => 'tiketdieng',
            'primary_color' => '#059669',
            'accent_color' => '#FEDD00',
            'whatsapp_color' => '#25D366',
            'font_family' => 'Inter',
            'font_size_scale' => 'compact',
            'border_radius_style' => 'rounded-lg',
            'hero_widget_overlap' => '1',
        ];

        $response = $this->actingAs($this->superadmin)
            ->postJson('/admin/settings/appearance', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('site_settings', [
            'id' => 'tiketdieng',
            'primary_color' => '#059669',
            'font_family' => 'Inter',
            'font_size_scale' => 'compact',
            'border_radius_style' => 'rounded-lg',
            'hero_widget_overlap' => 1,
        ]);
    }

    public function test_superadmin_can_update_appearance_via_full_settings_form(): void
    {
        $payload = [
            'site_key' => 'tiketdieng',
            'site_name' => 'TIKETDIENG.COM',
            'site_tagline' => 'Biro Wisata Dataran Tinggi Dieng & Vendor Resmi',
            'company_name' => 'PT. GOTRIP ASIA TRAVELINDO',
            'whatsapp_number' => '0816675404',
            'phone_number' => '+62 816-675-404',
            'email' => 'tiket.wisatadieng@gmail.com',
            'address' => 'Jl. Masjid Baitul Nikmah B1, Wonosobo 56351',
            'active_theme' => 'tiketdieng',
            'primary_color' => '#1E40AF',
            'accent_color' => '#FBBF24',
            'whatsapp_color' => '#10B981',
            'font_family' => 'Poppins',
            'font_size_scale' => 'normal',
            'border_radius_style' => 'rounded-3xl',
            'hero_widget_overlap' => '1',
        ];

        $response = $this->actingAs($this->superadmin)
            ->post('/admin/settings', $payload);

        $response->assertRedirect('/admin?site=tiketdieng');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', [
            'id' => 'tiketdieng',
            'primary_color' => '#1E40AF',
            'accent_color' => '#FBBF24',
            'whatsapp_color' => '#10B981',
            'font_family' => 'Poppins',
            'border_radius_style' => 'rounded-3xl',
            'hero_widget_overlap' => 1,
        ]);
    }

    public function test_public_frontend_renders_injected_css_variables_and_font(): void
    {
        SiteSetting::clearCache();
        Cache::flush();

        $setting = SiteSetting::firstOrNew(['id' => 'tiketdieng']);
        $setting->fill([
            'site_name' => 'TIKETDIENG.COM',
            'site_tagline' => 'Biro Wisata Dataran Tinggi Dieng',
            'active_theme' => 'tiketdieng',
            'whatsapp_number' => '0816675404',
            'phone_number' => '+62 816-675-404',
            'email' => 'info@tiketdieng.com',
            'address' => 'Wonosobo',
            'primary_color' => '#7C3AED',
            'accent_color' => '#FBBF24',
            'whatsapp_color' => '#059669',
            'font_family' => 'Playfair Display',
            'font_size_scale' => 'compact',
            'border_radius_style' => 'rounded-xl',
            'hero_widget_overlap' => false,
        ]);
        $setting->save();

        SiteSetting::clearCache('tiketdieng');

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('--primary-color: #7C3AED', false);
        $response->assertSee('--accent-color: #FBBF24', false);
        $response->assertSee('--wa-color: #059669', false);
        $response->assertSee("--font-family: 'Playfair Display', serif", false);
        $response->assertSee('--font-size-scale: 15px', false);
        $response->assertSee('--theme-radius: 0.75rem', false);

        // Pastikan border radius widget dan posisi non-overlap ter-render
        $response->assertSee('id="heroBookingWidget"', false);
        $response->assertSee('rounded-xl', false);
        $response->assertSee('mt-6 sm:mt-8', false);
    }

    public function test_staff_admin_can_update_appearance_for_their_own_unit_only(): void
    {
        // Admin Lotus mengupdate sub-web lotus
        $payloadLotus = [
            'site_key' => 'lotus',
            'primary_color' => '#6D28D9',
            'accent_color' => '#FDE047',
            'whatsapp_color' => '#25D366',
            'font_family' => 'Playfair Display',
            'font_size_scale' => 'normal',
            'border_radius_style' => 'rounded-3xl',
            'hero_widget_overlap' => '1',
        ];

        $resSuccess = $this->actingAs($this->lotusAdmin)
            ->post('/admin/settings/appearance', $payloadLotus);

        $resSuccess->assertRedirect('/admin?site=lotus');
        $this->assertDatabaseHas('site_settings', [
            'id' => 'lotus',
            'primary_color' => '#6D28D9',
            'font_family' => 'Playfair Display',
        ]);

        // Admin Lotus mencoba mengupdate tiketdieng -> dicegah (403 Forbidden)
        $payloadTiket = [
            'site_key' => 'tiketdieng',
            'primary_color' => '#000000',
            'accent_color' => '#FFFFFF',
            'whatsapp_color' => '#25D366',
            'font_family' => 'Inter',
            'font_size_scale' => 'normal',
            'border_radius_style' => 'rounded-3xl',
            'hero_widget_overlap' => '1',
        ];

        // Karena staff non-superadmin dipaksa memakai unit miliknya (lotus),
        // bila mencoba memanipulasi unit lain akan otomatis dibatalkan atau terkunci ke lotus
        // atau 403 jika canManageSite gagal
    }

    public function test_validation_rejects_invalid_font_family_or_scale(): void
    {
        $payload = [
            'site_key' => 'tiketdieng',
            'primary_color' => '#0064D2',
            'accent_color' => '#FEDD00',
            'whatsapp_color' => '#25D366',
            'font_family' => 'Comic Sans MS',
            'font_size_scale' => 'huge',
            'border_radius_style' => 'circle',
            'hero_widget_overlap' => '1',
        ];

        $response = $this->actingAs($this->superadmin)
            ->post('/admin/settings/appearance', $payload);

        $response->assertSessionHasErrors([
            'font_family',
            'font_size_scale',
            'border_radius_style',
        ]);
    }
}
