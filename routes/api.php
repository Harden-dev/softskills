<?php

use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DevisController;
use App\Http\Controllers\API\ServiceController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// route pour la reception des messages des utilisateurs(contacts)

Route::get('/message-user',[ ContactController::class, 'index']);
Route::post('/message-save',[ ContactController::class,'store']);

// route pour les services

Route::get('/services-list', [ServiceController::class, 'index']);
Route::post('services-save', [ServiceController::class, 'store']);

// route pour les demandes de devis

Route::get('/devis-list', [DevisController::class, 'index']);
Route::post('devis-save', [DevisController::class, 'store']);
