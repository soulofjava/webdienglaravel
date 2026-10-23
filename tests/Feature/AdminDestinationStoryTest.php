<?php

namespace Tests\Feature;

use App\Models\DestinationStory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminDestinationStoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::firstOrCreate(
            ['email' => 'admin@tiketdieng.com'],
            [
                'name' => 'Administrator TiketDieng',
                'password' => bcrypt('password'),
            ]
        );
        $this->admin->syncRoles([$role]);
    }

    public function test_public_homepage_renders_destination_stories_correctly(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('5 Babak Keajaiban Dataran Tinggi Para Dewa');
        $response->assertSee('Matahari Pertama di Puncak Sikunir');
    }

    public function test_admin_can_view_stories_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.stories.index'));
        $response->assertStatus(200);
        $response->assertSee('5 Babak Keajaiban Dataran Tinggi');
        $response->assertSee('Matahari Pertama di Puncak Sikunir');
    }

    public function test_admin_can_view_stories_create_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.stories.create'));
        $response->assertStatus(200);
        $response->assertSee('Tambah Babak Cerita Keajaiban');
    }

    public function test_admin_can_store_update_toggle_and_destroy_story(): void
    {
        // 1. Store
        $payload = [
            'chapter_badge' => 'BAB 06 • 2.200 MDPL',
            'title' => 'Misteri Telaga Dringo yang Sunyi',
            'quote' => '“Telaga sunyi di ketinggian Dieng.”',
            'description' => 'Telaga tertinggi yang sering dijuluki Ranu Kumbolo Jawa Tengah.',
            'highlights' => ['Suasana sunyi nan asri', 'Spot camping favorit', 'Jalur offroad menantang'],
            'image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=75',
            'accent_color' => 'emerald',
            'icon' => 'droplets',
            'sort_order' => 6,
            'is_active' => '1',
        ];

        $storeResponse = $this->actingAs($this->admin)->post(route('admin.stories.store'), $payload);
        $storeResponse->assertRedirect(route('admin.stories.index'));
        $storeResponse->assertSessionHas('success');

        $story = DestinationStory::where('title', 'Misteri Telaga Dringo yang Sunyi')->first();
        $this->assertNotNull($story);
        $this->assertEquals('BAB 06 • 2.200 MDPL', $story->chapter_badge);
        $this->assertEquals('emerald', $story->accent_color);
        $this->assertCount(3, $story->highlights);

        // 2. Edit view
        $editResponse = $this->actingAs($this->admin)->get(route('admin.stories.edit', $story->id));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Misteri Telaga Dringo yang Sunyi');

        // 3. Update
        $updatedPayload = array_merge($payload, [
            'title' => 'Pesona Alam Telaga Dringo Dieng',
            'accent_color' => 'indigo',
        ]);
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.stories.update', $story->id), $updatedPayload);
        $updateResponse->assertRedirect(route('admin.stories.index'));

        $story->refresh();
        $this->assertEquals('Pesona Alam Telaga Dringo Dieng', $story->title);
        $this->assertEquals('indigo', $story->accent_color);

        // 4. Toggle Status
        $toggleResponse = $this->actingAs($this->admin)->patch(route('admin.stories.toggle', $story->id));
        $toggleResponse->assertRedirect();
        $story->refresh();
        $this->assertFalse($story->is_active);

        // 5. Destroy
        $destroyResponse = $this->actingAs($this->admin)->delete(route('admin.stories.destroy', $story->id));
        $destroyResponse->assertRedirect(route('admin.stories.index'));
        $this->assertNull(DestinationStory::find($story->id));
    }
}
