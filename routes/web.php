<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MonetaryFlowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;

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

Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/usuarios', UserController::class);
Route::resource('/flujo', MonetaryFlowController::class);

Route::get('/configuracion', [SettingsController::class, 'index']);
Route::post('/concepto', [SettingsController::class, 'SaveConcept']);
