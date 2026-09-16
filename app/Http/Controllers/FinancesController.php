<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\ReservaAdmin;

class FinancesController extends Controller
{
    public function index()
    {
        $now = now();

        $inicioSemana = $now->copy()->startOfWeek()->toDateString();
        $finSemana = $now->copy()->endOfWeek()->toDateString();

        $inicioMes = $now->copy()->startOfMonth()->toDateString();
        $finMes = $now->copy()->endOfMonth()->toDateString();

        $hoy = $now->toDateString();

        // Facturación confirmada de eventos ya celebrados.
        $total_facturado = ReservaAdmin::where('estado', 'confirmada')
            ->whereHas('reserva', function ($query) use ($hoy) {
                $query->whereDate('fecha_evento', '<=', $hoy);
            })
            ->sum('total');

        // Facturación confirmada del mes.
        $total_facturado_mes = ReservaAdmin::where('estado', 'confirmada')
            ->whereHas('reserva', function ($query) use ($inicioMes, $finMes, $now) {
                $query->whereBetween('fecha_evento', [
                    $inicioMes,
                    $finMes
                ]);
                $query->whereDate('fecha_evento', '<=',$now);
            })
            ->sum('total');

        // Facturación esperada del mes.
        $total_facturado_mes_esperado = ReservaAdmin::whereIn('estado', [
                'confirmada',
                'pendiente'
            ])
            ->whereHas('reserva', function ($query) use ($inicioMes, $finMes) {
                $query->whereBetween('fecha_evento', [
                    $inicioMes,
                    $finMes
                ]);
            })
            ->sum('total');

        // Número de reservas del mes.
        $total_reservas_mes = Reserva::whereBetween('fecha_evento', [
            $inicioMes,
            $finMes
        ])->count();

        // Número de reservas de la semana.
        $total_reservas_semana = Reserva::whereBetween('fecha_evento', [
            $inicioSemana,
            $finSemana
        ])->count();

        // Facturación confirmada de la semana.
        $total_facturado_semana = ReservaAdmin::where('estado', 'confirmada')
            ->whereHas('reserva', function ($query) use ($inicioSemana, $finSemana) {
                $query->whereBetween('fecha_evento', [
                    $inicioSemana,
                    $finSemana
                ]);
                $query->whereDate('fecha_evento', '<=', $finSemana);
            })
            ->sum('total');

        // Facturación esperada de la semana.
        $total_facturado_semana_esperado = ReservaAdmin::whereIn('estado', [
                'confirmada',
                'pendiente'
            ])
            ->whereHas('reserva', function ($query) use ($inicioSemana, $finSemana) {
                $query->whereBetween('fecha_evento', [
                    $inicioSemana,
                    $finSemana
                ]);
            })
            ->sum('total');

        // Facturación confirmada del año.
        $total_facturado_ano = ReservaAdmin::where('estado', 'confirmada')
            ->whereHas('reserva', function ($query) use ($now) {
                $query->whereYear('fecha_evento', $now->year);
                $query->whereDate('fecha_evento', '<=', $now);
            })
            ->sum('total');

        // Facturación esperada del año.
        $total_facturado_ano_esperado = ReservaAdmin::whereIn('estado', [
                'confirmada',
                'pendiente'
            ])
            ->whereHas('reserva', function ($query) use ($now) {
                $query->whereYear('fecha_evento', $now->year);
                
            })
            ->sum('total');

        // Facturación confirmada del día.
        $total_facturado_dia = ReservaAdmin::where('estado', 'confirmada')
            ->whereHas('reserva', function ($query) use ($hoy) {
                $query->whereDate('fecha_evento', $hoy);
            })
            ->sum('total');

        // Facturación esperada del día.
        $total_facturado_dia_esperado = ReservaAdmin::whereIn('estado', [
                'confirmada',
                'pendiente'
            ])
            ->whereHas('reserva', function ($query) use ($hoy) {
                $query->whereDate('fecha_evento', $hoy);
                
                
            })
            ->sum('total');

        // Número de reservas del día.
        $total_reservas_dia = Reserva::whereDate(
            'fecha_evento',
            $hoy
        )->count();

        // Número de reservas del año.
        $total_reservas_ano = Reserva::whereYear(
            'fecha_evento',
            $now->year
        )->count();

        // Facturación esperada total, sin filtro de fecha.
        $total_facturado_esperado = ReservaAdmin::whereIn('estado', [
            'confirmada',
            'pendiente'
        ])->sum('total');

        return response()->json([
            'total_facturado' => $total_facturado,

            'total_facturado_mes' => $total_facturado_mes,
            'total_facturado_mes_esperado' => $total_facturado_mes_esperado,

            'total_reservas_mes' => $total_reservas_mes,
            'total_reservas_semana' => $total_reservas_semana,

            'total_facturado_semana' => $total_facturado_semana,
            'total_facturado_semana_esperado' => $total_facturado_semana_esperado,

            'total_facturado_ano' => $total_facturado_ano,
            'total_facturado_ano_esperado' => $total_facturado_ano_esperado,

            'total_facturado_dia' => $total_facturado_dia,
            'total_facturado_dia_esperado' => $total_facturado_dia_esperado,

            'total_reservas_dia' => $total_reservas_dia,
            'total_reservas_ano' => $total_reservas_ano,

            'total_facturado_esperado' => $total_facturado_esperado,
        ]);
    }
}