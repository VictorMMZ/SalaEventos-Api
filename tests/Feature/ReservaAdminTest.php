<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Reserva;
use App\Models\Sala;
use App\Models\ReservaAdmin;

class ReservaAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_puede_ver_reservas(): void{
        $user = User::factory()->create();
        $sala = Sala::factory()->create();
        $reserva = Reserva::factory()->create([
            'sala_id' => $sala->id,
        ]);

        $response = $this->actingAs($user)->getJson('/api/reservasadmin/');

        $response->assertStatus(200);
    }

    public function test_admin_puede_editar_reserva(): void{
        $user = User::factory()->create();
        $sala = Sala::factory()->create();
        $reserva = Reserva::factory()->create([
            'sala_id' => $sala->id,
        ]);

        $reserva_admin = ReservaAdmin::factory()->create([
            'reserva_id' => $reserva->id,
        ]);

        $response = $this->actingAs($user)->putJson('/api/adminreservas/'. $reserva_admin->id, [
            
            'precio' => 100,
            'descuento' => 10,
            'fianza' => 50,
            'metodo_pago' => 'tarjeta',
            'estado' => 'confirmada',
            
        ]);

      

        $response->assertStatus(200);
        $this->assertDatabaseHas('reserva_admins', [
            
            'precio' => 100,
            'descuento' => 10,
            'fianza' => 50,
            'metodo_pago' => 'tarjeta',
            'estado' => 'confirmada',
        ]);
    }

    public function test_admin_no_puede_ver_reservas_sin_autenticacion(): void{
        $response = $this->getJson('/api/reservasadmin/');

        $response->assertStatus(401);
    }

    public function test_admin_puede_eliminar_reserva(): void{
        $user = User::factory()->create();
        $sala = Sala::factory()->create();
        $reserva = Reserva::factory()->create([
            'sala_id' => $sala->id,
        ]);
        $reserva_admin = ReservaAdmin::factory()->create([
            'reserva_id' => $reserva->id,
        ]);

        $response = $this->actingAs($user)->deleteJson('/api/adminreservas/'. $reserva_admin->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('reserva_admins', [
            'id' => $reserva_admin->id,
        ]);
    }

    public function test_admin_puede_ver_detalle_reserva(): void{
        $user = User::factory()->create();
        $sala = Sala::factory()->create();
        $reserva = Reserva::factory()->create([
            'sala_id' => $sala->id,
        ]);
        $reserva_admin = ReservaAdmin::factory()->create([
            'reserva_id' => $reserva->id,
        ]);

        $response = $this->actingAs($user)->getJson('/api/reservas/'. $reserva_admin->reserva_id);

        $response->assertStatus(200);
    }
}