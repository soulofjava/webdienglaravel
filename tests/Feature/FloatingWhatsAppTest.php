<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FloatingWhatsAppTest extends TestCase
{
    use RefreshDatabase;
    public function test_floating_whatsapp_button_is_rendered_on_public_home(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Chat WhatsApp');
        $response->assertSee('https://wa.me/', false);
    }

    public function test_floating_whatsapp_button_is_rendered_on_sub_themes(): void
    {
        $lotusResponse = $this->get('/?theme=lotus');
        $lotusResponse->assertStatus(200);
        $lotusResponse->assertSee('Chat WhatsApp');
        $lotusResponse->assertSee('https://wa.me/', false);

        $jeepResponse = $this->get('/?theme=jeep');
        $jeepResponse->assertStatus(200);
        $jeepResponse->assertSee('Chat WhatsApp');
        $jeepResponse->assertSee('https://wa.me/', false);

        $shuttleResponse = $this->get('/?theme=shuttle');
        $shuttleResponse->assertStatus(200);
        $shuttleResponse->assertSee('Chat WhatsApp');
        $shuttleResponse->assertSee('https://wa.me/', false);
    }
}
