<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\ReservasAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\FinancesController;







// RUTAS PÚBLICAS

Route::middleware('web')->group(function () {

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::get('/sala', [SalasController::class, 'index']);

    Route::post('/reservas', [ReservasController::class, 'store']);

});

// RUTAS PRIVADAS

Route::middleware(['web', 'auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // 2FA
    Route::get('/2fa/setup', [TwoFactorController::class, 'setup']);
    Route::post('/2fa/setup/verify', [TwoFactorController::class, 'verifySetup']);
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify']);

    // Reservas
    Route::get('/reservas', [ReservasController::class, 'index']);
    Route::get('/reservas/{id}', [ReservasController::class, 'show']);
    Route::put('/reservas/{id}', [ReservasController::class, 'update']);
    Route::delete('/reservas/{id}', [ReservasController::class, 'destroy']);

    // Administración de reservas
    Route::get('/adminreservas', [ReservasAdminController::class, 'index']);
    Route::put('/adminreservas/{id}', [ReservasAdminController::class, 'update']);
    Route::delete('/adminreservas/{id}', [ReservasAdminController::class, 'destroy']);
    Route::patch('/adminreservas/{id}/estado', [ReservasAdminController::class, 'updateReservaEstado']);

    // Finanzas
    Route::get('/finanzas', [FinancesController::class, 'index']);

    // Salas
    Route::post('/sala', [SalasController::class, 'store']);
    Route::get('/sala/{id}', [SalasController::class, 'show']);
    Route::put('/sala/{id}', [SalasController::class, 'update']);
    Route::delete('/sala/{id}', [SalasController::class, 'destroy']);

});

