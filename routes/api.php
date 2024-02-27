<?php

use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DevisController;
use App\Http\Controllers\API\LetterController;
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

Route::get('/message-user', [ContactController::class, 'index']);
Route::post('/message-save', [ContactController::class, 'store']);
Route::delete('/message-delete/{id}', [ContactController::class, 'destroy']); //supprimer un message en fonction de

// route pour les services

Route::get('/services-list', [ServiceController::class, 'index']);
Route::post('services-save', [ServiceController::class, 'store']);
Route::delete('/services-delete/{id}', [ServiceController::class, 'destroy']);

// route pour les demandes de devis

Route::get('/devis-list', [DevisController::class, 'index']);
Route::post('devis-save', [DevisController::class, 'store']);
Route::delete('/devis-delete/{id}', [DevisController::class, 'destroy']);

// route pour les letters

Route::get('/email-list', [LetterController::class, 'index']);
Route::post('email-save', [LetterController::class, 'store']);
Route::delete('/email-delete/{id}', [LetterController::class, 'destroy']);
