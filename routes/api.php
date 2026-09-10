<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\ReservasAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalasController;

Route::middleware('web')->group(function () {

    // Públicas
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/reservas', [ReservasController::class, 'store']);

    Route::get('/2fa/setup', [TwoFactorController::class, 'setup']);
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify']);

    // Privadas
    Route::middleware('auth')->group(function () {

        Route::post('/sala', [SalasController::class, 'store']);
        Route::get('/sala', [SalasController::class, 'index']);
        Route::get('/sala/{id}', [SalasController::class, 'show']);
        Route::put('/sala/{id}', [SalasController::class, 'update']);
        Route::delete('/sala/{id}', [SalasController::class, 'destroy']);

        Route::get('/reservasadmin', [ReservasAdminController::class, 'index']);
        Route::put('/adminreservas/{id}', [ReservasAdminController::class, 'update']);
        Route::delete('/adminreservas/{id}', [ReservasAdminController::class, 'destroy']);

        Route::get('/reservas', [ReservasController::class, 'index']);
        Route::get('/reservas/{id}', [ReservasController::class, 'show']);
        Route::put('/reservas/{id}', [ReservasController::class, 'update']);
        Route::delete('/reservas/{id}', [ReservasController::class, 'destroy']);
    });
});
