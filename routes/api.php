<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\ReservasAdminController;
use App\Http\Controllers\AuthController;

 Route::post('/reservas', [ReservasController::class, 'store']);
 Route::get('/2fa/setup', [TwoFactorController::class, 'setup']);
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify']);
   
    Route::get('/reservas', [ReservasController::class, 'index']);
    Route::get('/reservas/{id}', [ReservasController::class, 'show']);
    Route::put('/reservas/{id}', [ReservasController::class, 'update']);
    Route::delete('/reservas/{id}', [ReservasController::class, 'destroy']);
Route::middleware('auth:sanctum')->group(function () {
    
});

