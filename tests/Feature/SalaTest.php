<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Sala;
use App\Models\User;
use Tests\TestCase;

class SalaTest extends TestCase
{

use RefreshDatabase;
    /** @test */
    public function test_usuario_crea_sala()
    {
         $sala= Sala::factory()->create();
         $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/api/sala', [
            'nombre' => $sala->nombre,
            'descripcion' => $sala->descripcion,
            'precio_hora' => $sala->precio_hora,
            'capacidad' => $sala->capacidad,
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function test_usuario_no_puede_crear_sala_sin_autenticacion()
    {
        $sala= Sala::factory()->create();
        $response = $this->post('/api/sala', [
            'nombre' => $sala->nombre,
            'descripcion' => $sala->descripcion,
            'precio_hora' => $sala->precio_hora,
            'capacidad' => $sala->capacidad,
        ]);

        $response->assertStatus(302);
    }

    /** @test */
    public function test_usuario_puede_ver_salas()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/api/sala');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_usuario_puede_editar_sala()
    {
        $sala = Sala::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->put('/api/sala/' . $sala->id, [
            'nombre' => 'Nuevo Nombre',
            'descripcion' => 'Nueva Descripcion',
            'precio_hora' => 100,
            'capacidad' => 50,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('salas', [
            'id' => $sala->id,
            'nombre' => 'Nuevo Nombre',
            'descripcion' => 'Nueva Descripcion',
            'precio_hora' => 100,
            'capacidad' => 50,
        ]);
    }
}