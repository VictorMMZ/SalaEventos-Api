<?php
namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

class Salas_Controller extends Controller{
    public function index()
    {
        $salas = Sala::all();
        return response()->json($salas);
    }

    public function show($id)
    {
        $sala = Sala::find($id);
        if ($sala) {
            return response()->json($sala);
        } else {
            return response()->json(['message' => 'Sala no encontrada'], 404);
        }
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio_hora' => 'required|decimal:0,2|min:0',
            'capacidad' => 'required|numeric|min:1'
        ]);

        $sala = Sala::create($validated);
        return response()->json([
            'sala' => $sala,
            'message' => 'Sala creada exitosamente'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $sala = Sala::find($id);
        if ($sala) {
            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:255',
                'descripcion' => 'sometimes|required|string|max:1000',
                'precio_hora' => 'sometimes|required|decimal:0,2|min:0',
                'capacidad' => 'sometimes|required|numeric|min:1'
            ]);
            $sala->update($validated);
            return response()->json([
                'sala' => $sala,
                'message' => 'Sala actualizada exitosamente'
            ]);
        } else {
            return response()->json(['message' => 'Sala no encontrada'], 404);
        }
    }
    public function destroy($id)
    {
        $sala = Sala::find($id);
        if ($sala) {
            $sala->delete();
            return response()->json(['message' => 'Sala eliminada exitosamente']);
        } else {
            return response()->json(['message' => 'Sala no encontrada'], 404);
        }
    }
}