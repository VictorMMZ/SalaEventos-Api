<?php
namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\ReservaAdmin;

class ReservasAdminController extends Controller{

public function index()
{
    $reservas_admin = ReservaAdmin::with('reserva')->get();

    return response()->json($reservas_admin);
}
public function show($id)
{
    $reserva_admin = ReservaAdmin::with('reserva')->find($id);

    if ($reserva_admin) {
        return response()->json($reserva_admin);
    }

    return response()->json([
        'message' => 'Reserva no encontrada'
    ], 404);
}
public function destroy($id)
{
    $reserva_admin = ReservaAdmin::find($id);
    if ($reserva_admin) {
        $reserva_admin->delete();
        return response()->json(['message' => 'Reserva eliminada exitosamente']);
    } else {
        return response()->json(['message' => 'Reserva no encontrada'], 404);
    }
}

public function getReservasBySala($sala_id)
{
    $reservas_admin = ReservaAdmin::with('reserva')
    ->whereHas('reserva', function ($query) use ($sala_id) {
            $query->where('sala_id', $sala_id);
        })
    ->get();
    return response()->json($reservas_admin);
}


public function update($id, Request $request)
{
    $reserva_admin = ReservaAdmin::find($id);
    if ($reserva_admin) {
        $validated = $request->validate([
            'precio' => 'sometimes|numeric|min:0',
            'descuento' => 'sometimes|numeric|min:0',
            'fianza' => 'sometimes|numeric|min:0',
            'metodo_pago' => 'sometimes|string|max:255',
            'estado' => 'sometimes|string|max:255',
        ]);
        
        $reserva_admin->update($validated);
        return response()->json(['message' => 'Reserva actualizada exitosamente', 'reserva' => $reserva_admin]);
    } else {
        return response()->json(['message' => 'Reserva no encontrada'], 404);
    }
}

public function getReservasByNombre($nombre)
{
    $reservas_admin = ReservaAdmin::with('reserva')
        ->whereHas('reserva', function ($query) use ($nombre) {
            $query->where('nombre_completo', 'like', '%' . $nombre . '%');
        })
        ->get();
    return response()->json($reservas_admin);
}
 
}

