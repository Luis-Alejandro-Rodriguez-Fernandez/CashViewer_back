<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\CuentasFamiliaController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\MovimientosFamiliaController;
use App\Http\Controllers\MovimientosTipoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    //Cuentas
    Route::prefix('/cuenta')->controller(CuentaController::class)->group(function () {
        Route::post('/', 'index');
        Route::post('/goals', 'getCuentasObjetivo');
        Route::post('/goals/set', 'setCuentaObjetivo');
        Route::post('/goals/end', 'finalizarObjetivo');
        Route::post('/goal/delete', 'deleteCuentaObjetivo');
    });

    //Movimientos
    Route::prefix('/movimientos')->controller(MovimientoController::class)->group(function () {
        Route::post('/', 'getMovimientos');
        Route::post('/set', 'setMovimiento');
        Route::post('/in', 'getEntradas');
        Route::post('/out', 'getSalidas');
        Route::post('/balance', 'getBalance');
        Route::post('/balance_by_time', 'getBalancePorEtapas');
        Route::post('/spend_by_type', 'getGastosPorTipo');
    });

    //Movimientos familias
    Route::prefix('movimientos_familias')->controller(MovimientosFamiliaController::class)->group(function (){
        Route::get('/', 'getMovimientosFamilias');
    });

    //Cuentas familias
    Route::prefix('cuentas_familias')->controller(CuentasFamiliaController::class)->group(function (){
        Route::get('/', 'getCuentasFamilias');
    });

    //Movimientos recurrencias

    //Movimientos tipos
    Route::prefix('movimientos_tipos')->controller(MovimientosTipoController::class)->group(function (){
        Route::get('/', 'getMovimientosTipos');
    });

});

Route::post('/registro', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
