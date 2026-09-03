<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas_admin', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('reserva_id')
                ->unique()
                ->constrained()
                ->restrictedOnDelete();
            $table->decimal('precio', 8, 2);
            $table->decimal('descuento', 8, 2);
            $table->decimal('sub_total', 8, 2);
            $table->decimal('iva', 8, 2);
            $table->decimal('total', 8, 2);
            $table->decimal('comision', 8, 2);
            $table->enum('metodo_pago', [
                'efectivo',
                'tarjeta',
                'transferencia',
                'bizum',
                'paypal'
            ]);
            $table->enum('estado', [
                'pendiente',
                'confirmada',
                'cancelada',
                'completada'
            ])->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas_admin');
    }
};
