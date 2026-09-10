<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Reserva;
use App\Models\Sala;
use Tests\TestCase;

class ReservaTest extends TestCase
{
    use RefreshDatabase;

  
    public function test_cliente_crea_reserva(): void{
      

        $sala= Sala::factory()->create();

        $response = $this->postJson('/api/reservas/', [
                'id' => 1,
                'sala_id' => $sala->id,
                'nombre_completo' => 'John Doe',
                'email' => 'johndoe@example.com',
                'telefono' => '123456789',
                'fecha_evento' => "2026-09-30",
                'hora_entrada' => "16:00",
                'hora_salida' => "19:00",
                'numero_ninos' => 2,
                'mensaje_adicional' => 'mensaje', 

            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('reservas', [
            'email' => 'johndoe@example.com',
        ]);
    }

    public function test_cliente_no_puede_crear_reserva_sin_datos(): void{
        $response = $this->postJson('/api/reservas/', []);

        $response->assertStatus(422);
    }

    public function test_cliente_no_puede_crear_reserva_con_hora_salida_anterior_a_entrada(): void{
        $sala= Sala::factory()->create();

        $response = $this->postJson('/api/reservas/', [
                'id' => 1,
                'sala_id' => $sala->id,
                'nombre_completo' => 'John Doe',
                'email' => 'johndoe@example.com',
                'telefono' => '123456789',
                'fecha_evento' => "2026-09-01",
                'hora_entrada' => "16:00",
                'hora_salida' => "15:00",
                'numero_ninos' => 2,
                'mensaje_adicional' => 'mensaje', 
            ]);

        $response->assertStatus(422);
    }


    public function test_cliente_no_puede_crear_reserva_con_fecha_pasada(): void{
        $sala= Sala::factory()->create();

        $response = $this->postJson('/api/reservas/', [
                'id' => 1,
                'sala_id' => $sala->id,
                'nombre_completo' => 'John Doe',
                'email' => 'johndoe@example.com',
                'telefono' => '123456789',
                'fecha_evento' => "2020-09-01",
                'hora_entrada' => "16:00",
                'hora_salida' => "19:00",
                'numero_ninos' => 2,
                'mensaje_adicional' => 'mensaje', 
            ]);

        $response->assertStatus(422);
    }
}
