<?php

namespace Database\Factories;

use App\Models\ReservaAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<ReservaAdmin>
 */
class ReservaAdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reserva_id' => \App\Models\Reserva::factory(),
            'precio' => $this->faker->numberBetween(50, 500),
            'descuento' => $this->faker->numberBetween(0, 50),
            'fianza' => $this->faker->numberBetween(0, 100),
            'metodo_pago' => $this->faker->randomElement(['tarjeta', 'efectivo', 'transferencia']),
            'total' => $this->faker->numberBetween(50, 500),
            'estado' => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada']),
        ];
    }
}