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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('sala_id')
                 -> constrained()
                 -> restrictedOnDelete();
            $table->string('nombre_completo');
            $table->string('email');
            $table->string('telefono', 9);
            $table->date('fecha_evento');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->integer('numero_ninos')->nullable();
            $table->text('mensaje_adicional');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
