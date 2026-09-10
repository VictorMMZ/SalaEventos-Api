<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\ReservaAdmin;
use App\Models\Sala;
use Carbon\Carbon;



class ReservasController extends Controller
{
    public function index()
    {
        $reservas = Reserva::all();
        return response()->json($reservas);
    }

    public function show($id)
    {
        $reserva = Reserva::find($id);
        if ($reserva) {
            return response()->json($reserva);
        } else {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }
    }

    public function comprobarfechayhora(Request $request)
    {
        $validated = $request->validate([
            'sala_id' => 'required|exists:salas,id',
            'fecha_evento' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i|max:10',
            'hora_salida' => 'required|date_format:H:i|max:10',
        ]);

        $entrada = Carbon::createFromFormat('H:i', $validated['hora_entrada']);
        $salida = Carbon::createFromFormat('H:i', $validated['hora_salida']);

        //  Comprobamos que la salida sea posterior a la entrada
        if ($salida->lessThanOrEqualTo($entrada)) {
            return response()->json([
                'errors' => [
                    'hora_salida' => 'La hora de salida debe ser posterior a la hora de entrada.'
                ]
            ], 422);
        }

        if ($this->existeConflicto(
            $validated['sala_id'],
            $validated['fecha_evento'],
            $validated['hora_entrada'],
            $validated['hora_salida']
        )) {
            return response()->json([
                'message' => 'Fecha y hora no disponibles'
            ], 409);
        }

        return response()->json([
            'message' => 'Fecha y hora disponibles'
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'sala_id' => 'required|exists:salas,id',
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|digits:9',
            'fecha_evento' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i|max:10',
            'hora_salida' => 'required|date_format:H:i|max:10',
            'numero_ninos' => 'required|numeric|min:0',
            'mensaje_adicional' => 'nullable|string|max:1000'
        ]);

        // Buscamos la sala
        $sala = Sala::findOrFail($validated['sala_id']);




        // Convertimos las horas
        $entrada = Carbon::createFromFormat('H:i', $validated['hora_entrada']);
        $salida = Carbon::createFromFormat('H:i', $validated['hora_salida']);

        //  Comprobamos que la salida sea posterior a la entrada
        if ($salida->lessThanOrEqualTo($entrada)) {
            return response()->json([
                'errors' => [
                    'hora_salida' => 'La hora de salida debe ser posterior a la hora de entrada.'
                ]
            ], 422);
        }
        // Comprobamos que la fecha del evento no sea en el pasado
        if ($validated['fecha_evento'] < date('Y-m-d')) {
            return response()->json([
                'errors' => [
                    'fecha_evento' => 'La fecha del evento no puede ser en el pasado.'
                ]
            ], 422);
        }
        // Comprobamos si hay conflictos de horario
        if ($this->existeConflicto(
            $validated['sala_id'],
            $validated['fecha_evento'],
            $validated['hora_entrada'],
            $validated['hora_salida']
        )) {
            return response()->json(['message' => 'Fecha y hora no disponibles'], 409);
        }



        // Calculamos las horas de la reserva
        $horas = $entrada->diffInHours($salida);

        // Creamos la reserva
        $reserva = Reserva::create($validated);

        //  Valores iniciales de administración
        $descuento = 0;
        $fianza = 0;

        //  Calculamos el total
        $total = ($sala->precio * $horas) - $descuento;

        // Creamos automáticamente ReservaAdmin
        ReservaAdmin::create([
            'reserva_id' => $reserva->id,
            'precio' => $sala->precio*$horas,
            'descuento' => $descuento,
            'fianza' => $fianza,
            'total' => $total,
        ]);
        return response()->json([
            'reserva' => $reserva,
            'message' => 'Reserva creada exitosamente'
        ], 201);
    }

    private function existeConflicto($salaId, $fecha, $horaEntrada, $horaSalida)
    {
        return Reserva::where('sala_id', $salaId)
            ->where('fecha_evento', $fecha)
            ->where('hora_entrada', '<', $horaSalida)
            ->where('hora_salida', '>', $horaEntrada)->exists();
    }

    public function destroy($id)
    {
        $reserva = Reserva::find($id);
        if ($reserva) {
            $reserva->delete();
            return response()->json(['message' => 'Reserva eliminada exitosamente']);
        } else {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }
    }
}
