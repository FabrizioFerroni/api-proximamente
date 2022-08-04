<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BajaSuscripcionController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

// suscribirme
Route::post('suscribirme', [SuscripcionController::class, 'store']);

// Baja subcripciones
Route::post('darse-de-baja/{email}', [BajaSuscripcionController::class, 'store']);
Route::get('baja-suscriptores', [BajaSuscripcionController::class, 'index']);


