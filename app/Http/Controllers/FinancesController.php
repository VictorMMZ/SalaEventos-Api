<?php
namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\ReservaAdmin;

class FinancesController extends Controller
{

    public function index()
    {
        $total_facturado     = ReservaAdmin::sum('total');
        $total_facturado_mes = ReservaAdmin::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->sum('total');

        $total_reservas_mes = Reserva::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();

        $total_reservas_semana  = Reserva::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $total_facturado_semana = ReservaAdmin::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total');
        $total_facturado_ano    = ReservaAdmin::whereYear('created_at', now()->year)->sum('total');
        $total_facturado_dia    = ReservaAdmin::whereDate('created_at', now()->toDateString())->sum('total');
        $total_reservas_dia     = Reserva::whereDate('created_at', now()->toDateString())->count();
        $total_reservas_ano     = Reserva::whereYear('created_at', now()->year)->count();

        return response()->json([
            'total_facturado'        => $total_facturado,
            'total_facturado_mes'    => $total_facturado_mes,
            'total_reservas_mes'     => $total_reservas_mes,
            'total_reservas_semana'  => $total_reservas_semana,
            'total_facturado_semana' => $total_facturado_semana,
            'total_facturado_ano'    => $total_facturado_ano,
            'total_facturado_dia'    => $total_facturado_dia,
            'total_reservas_dia'     => $total_reservas_dia,
            'total_reservas_ano'     => $total_reservas_ano,
        ]);
    }
}
