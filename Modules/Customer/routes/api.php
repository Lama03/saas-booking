<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\App\Http\Controllers\Api\CustomerController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('customers', CustomerController::class)->names('customer');
});


Route::middleware(['auth:sanctum'])->prefix('v1')->group(callback: function () {
    Route::put('/customers/{id}', [CustomerController::class, 'update']);
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(callback: function () {
    Route::get('/customers/bookings/{id}', [CustomerController::class, 'showClientFromBooking']);
});