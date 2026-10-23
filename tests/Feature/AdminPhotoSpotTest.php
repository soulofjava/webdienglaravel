<?php

namespace Tests\Feature;

use App\Models\PhotoSpot;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPhotoSpotTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        SiteSetting::create([
            'site_scope' => 'global',
            'site_name' => 'Tiket Wisata Dieng',
            'phone_number' => '081325631952',
            'whatsapp_number' => '081325631952',
            'email' => 'halo@tiketdieng.com',
            'address' => 'Wonosobo',
        ]);

        $superadminRole = Role::create(['name' => 'superadmin']);
        $this->adminUser = User::factory()->create([
            'email' => 'superadmin@tiketdieng.com',
        ]);
        $this->adminUser->assignRole($superadminRole);
    }

    public function test_admin_can_view_photo_spots_index(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.photo-spots.index'));

        $response->assertStatus(200);
        $response->assertSee('Spot Foto Favorit Dieng');
        $response->assertSee('Bukit Sikunir Golden Sunrise');
    }

    public function test_admin_can_create_photo_spot_via_url(): void
    {
        $response = $this->actingAs($this->adminUser)->post(route('admin.photo-spots.store'), [
            'site_scope' => 'lotus',
            'name' => 'Gunung Prau Sunrise Point',
            'best_time_tag' => '04.30 WIB',
            'description' => 'Bukit teletubbies dan bunga daisy dengan panorama Sindoro Sumbing.',
            'image_url' => 'https://images.unsplash.com/photo-prau',
            'sort_order' => 5,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.photo-spots.index'));
        $this->assertDatabaseHas('photo_spots', [
            'site_scope' => 'lotus',
            'name' => 'Gunung Prau Sunrise Point',
            'best_time_tag' => '04.30 WIB',
            'sort_order' => 5,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_upload_photo_spot_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('spot_test.jpg', 800, 600);

        $response = $this->actingAs($this->adminUser)->post(route('admin.photo-spots.store'), [
            'site_scope' => 'jeep',
            'name' => 'Telaga Dringo Oase Tersembunyi',
            'best_time_tag' => 'Landscape',
            'description' => 'Ranu Kumbolo-nya Dieng dengan danau kawah alami.',
            'image_file' => $file,
            'sort_order' => 6,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.photo-spots.index'));
        $this->assertDatabaseHas('photo_spots', [
            'site_scope' => 'jeep',
            'name' => 'Telaga Dringo Oase Tersembunyi',
        ]);
    }

    public function test_admin_can_update_photo_spot(): void
    {
        $spot = PhotoSpot::first();

        $response = $this->actingAs($this->adminUser)->put(route('admin.photo-spots.update', $spot->id), [
            'site_scope' => $spot->site_scope,
            'name' => 'Puncak Sikunir Golden Sunrise VIP',
            'best_time_tag' => '05.15 WIB',
            'description' => 'Deskripsi baru yang diperbarui oleh admin.',
            'image_url' => $spot->image_url,
            'sort_order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.photo-spots.index'));
        $this->assertDatabaseHas('photo_spots', [
            'id' => $spot->id,
            'name' => 'Puncak Sikunir Golden Sunrise VIP',
            'best_time_tag' => '05.15 WIB',
        ]);
    }

    public function test_admin_can_toggle_and_delete_photo_spot(): void
    {
        $spot = PhotoSpot::first();

        $toggleRes = $this->actingAs($this->adminUser)->patch(route('admin.photo-spots.toggle', $spot->id));
        $toggleRes->assertStatus(302);
        $this->assertDatabaseHas('photo_spots', [
            'id' => $spot->id,
            'is_active' => false,
        ]);

        $delRes = $this->actingAs($this->adminUser)->delete(route('admin.photo-spots.destroy', $spot->id));
        $delRes->assertRedirect(route('admin.photo-spots.index'));
        $this->assertDatabaseMissing('photo_spots', [
            'id' => $spot->id,
        ]);
    }
}
