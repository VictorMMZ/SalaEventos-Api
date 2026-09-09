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
        Schema::create('reserva_admins', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('reserva_id')
                ->unique()
                ->constrained()
                ->restrictedOnDelete();
            $table->decimal('precio', 8, 2);
            $table->decimal('descuento', 8, 2);
            $table->decimal('total', 8, 2);
            $table->decimal('fianza', 8, 2);
            $table->enum('metodo_pago', [
                'a definir',
                'efectivo',
                'tarjeta',
                'transferencia',
                'bizum',
                'paypal'
            ])->default('a definir');
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
        Schema::dropIfExists('reserva_admins');
    }
};
