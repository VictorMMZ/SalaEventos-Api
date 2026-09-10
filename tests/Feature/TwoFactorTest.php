<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Reserva;

class TwoFactorTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_configurar_2fa(): void
    {
        $user = User::factory()->create([
            'totp_enabled' => false,
            'totp_secret' => null,
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/2fa/setup');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'qr_code_url',
        ]);

        $user->refresh();

        $this->assertNotNull($user->totp_secret);
    }
     public function test_usuario_no_puede_configurar_2fa(): void
    {
        $user = User::factory()->create([
            'totp_enabled' => true,
            'totp_secret' => null,
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/2fa/setup');

        $response->assertStatus(400);

        $response->assertJsonStructure([
            'message',
        ]);

        $user->refresh();

        $this->assertNull($user->totp_secret);
    }


}