<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/patients', [PatientController::class, 'index']);
    Route::get('/patients/{id}', [PatientController::class, 'show']);
    Route::post('/patients', [PatientController::class, 'store']);
    Route::patch('/patients/{id}', [PatientController::class, 'update']);
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

    Route::get('/patients/search/{name}', [PatientController::class, 'search']);
    Route::get('/patients/status/positive', [PatientController::class, 'positive']);
    Route::get('/patients/status/recovered', [PatientController::class, 'recovered']);
    Route::get('/patients/status/dead', [PatientController::class, 'dead']);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
