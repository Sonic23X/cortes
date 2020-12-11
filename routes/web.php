<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MonetaryFlowController;
use App\Http\Controllers\UserController;

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

Route::get('/pagos', function (Request $request) {
   return view('courierPayment/payment_main_table.blade.php');
});

Route::resource('usuarios', UserController::class);
Route::resource('flujo', MonetaryFlowController::class);
