<?php

use Illuminate\Support\Facades\Route;
use Modules\Booking\App\Http\Controllers\Api\BookingController;

use Illuminate\Http\Request;


Route::prefix('v1')->group(function () {
    Route::apiResource('bookings', BookingController::class)->names('booking');
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::put('/bookings/{id}/{status}', [BookingController::class, 'updateStatus']);
});

Route::get('/home-page/{tenantId}', [BookingController::class, 'Home']);


Route::get('/test-booking', [BookingController::class, 'test']);
