<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MonetaryFlowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\RetetionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function() {

    Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/usuarios', UserController::class);
    Route::post('/usuarios/updateStatus', [UserController::class, 'setStatus']);
    Route::post('/usuarios/updateTerminal', [UserController::class, 'setTerminal']);

    Route::resource('/flujo', MonetaryFlowController::class);
    Route::post('/flujo/concepto', [MonetaryFlowController::class, 'checkConcept']);
    Route::post('/flujo/filtro', [MonetaryFlowController::class, 'dateFilterTable']);
    Route::get('/flujo/cuenta/{id}', [MonetaryFlowController::class, 'concepts']);
    Route::post('/flujo/filtro/cuenta', [MonetaryFlowController::class, 'dateFilterConcepts']);

    Route::resource('/resumen', ResumeController::class);
    Route::post('/resumen/filtro', [ResumeController::class, 'dateFilterTable']);

    Route::post('/corte', [ResumeController::class, 'nuevoCorte']);
    Route::post('/cortes/updatenombre', [ResumeController::class, 'updateCorteName']);
    Route::post('/cortes/updatemonto', [ResumeController::class, 'updateCorteMonto']);
    Route::delete('/corte/{id}', [ResumeController::class, 'deleteCorte']);

    Route::get('/resumen/pedidoscobrados/{id}', [ResumeController::class, 'detallesPagosCobrados']);
    Route::post('/resumen/pedidoscobrados/filtros', [ResumeController::class, 'detallesPagosCobradosFiltro']);

    Route::get('/resumen/pagosurbo/{id}', [ResumeController::class, 'detallesPagosUrbo']);
    Route::post('/resumen/pagosurbo/filtros', [ResumeController::class, 'detallesPagosUrboFiltro']);

    Route::get('/resumen/pagosrepartido/{id}', [ResumeController::class, 'detallesPagosRepartidor']);
    Route::post('/resumen/pagosrepartido/filtros', [ResumeController::class, 'detallesPagosRepartidorFiltro']);

    Route::get('/resumen/cortes/{id}', [ResumeController::class, 'detallesCortes']);
    Route::post('/resumen/cortes/filtros', [ResumeController::class, 'detallesCortesFiltro']);

    Route::resource('/pagos', ChargeController::class);
    Route::post('/pagos/updatemonto', [ChargeController::class, 'updateMonto']);
    Route::post('/pagos/updatenegocio', [ChargeController::class, 'updatePlace']);
    Route::post('/pagos/updaterepartidor', [ChargeController::class, 'updateCourier']);
    Route::post('/pagos/updatepedido', [ChargeController::class, 'updateOrder']);
    Route::post('/pagos/updatefecha', [ChargeController::class, 'updateDate']);

    Route::get('/configuracion', [SettingsController::class, 'index']);
    Route::post('/concepto', [SettingsController::class, 'SaveConcept']);
    Route::post('/cuenta', [SettingsController::class, 'SaveAccount']);
    Route::post('/negocio', [SettingsController::class, 'SavePlace']);
    Route::post('/hoja', [SettingsController::class, 'SaveSheet']);

    Route::resource('/saldos', BalanceController::class);

    Route::resource('/hojas', SheetController::class);

    Route::resource('/retenciones', RetetionController::class);
});
