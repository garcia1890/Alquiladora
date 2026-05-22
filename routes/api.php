<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientesController;
use App\Http\Controllers\Api\Codigos2FAController;
use App\Http\Controllers\Api\DetalleRentasController;
use App\Http\Controllers\Api\EmpleadosController;
use App\Http\Controllers\Api\EntregasController;
use App\Http\Controllers\Api\PagosController;
use App\Http\Controllers\Api\ProductosController;
use App\Http\Controllers\Api\RentasController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\UsuariosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Al usar apiResource, Laravel asume automáticamente los métodos index, store, show, update y destroy.
Route::apiResource('clientes', ClientesController::class);
Route::apiResource('codigos-2fa', Codigos2FAController::class);
Route::apiResource('detalle-rentas', DetalleRentasController::class);
Route::apiResource('empleados', EmpleadosController::class);
Route::apiResource('entregas', EntregasController::class);
Route::apiResource('pagos', PagosController::class);
Route::apiResource('productos', ProductosController::class);
Route::apiResource('rentas', RentasController::class);
Route::apiResource('roles', RolesController::class);
Route::apiResource('usuarios', UsuariosController::class);