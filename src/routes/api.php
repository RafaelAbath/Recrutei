<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/vehicles/search', [VehicleController::class, 'search']);
    Route::apiResource('vehicles', VehicleController::class);
    
    // ---------- Reports ----------
    Route::get('reports/revenue', [ReportController::class, 'revenue']);
    // ---------- Customers ----------
    Route::apiResource('customers', CustomerController::class);

    // ---------- Rentals ----------
    Route::post('/rentals',               [RentalController::class, 'store']);
    Route::post('/rentals/{rental}/start',[RentalController::class, 'start']);
    Route::post('/rentals/{rental}/end',  [RentalController::class, 'end']);
    Route::get('/rentals',                [RentalController::class, 'index']);
    Route::get('/rentals/{rental}',       [RentalController::class, 'show']);
});
