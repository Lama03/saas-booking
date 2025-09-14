<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\App\Http\Controllers\Api\PaymentController;

Route::middleware(['auth:sanctum'])->prefix(prefix: 'v1')->group(function () {
    Route::apiResource('payments', PaymentController::class)->names('payment');
});


Route::middleware(['auth:sanctum'])->prefix('v1')->group(callback: function () {
    Route::get('/payments/bookings/{id}', [PaymentController::class, 'showPaymentFromBooking']);
});