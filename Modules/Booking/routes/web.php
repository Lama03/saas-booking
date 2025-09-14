<?php

use Illuminate\Support\Facades\Route;

/**
 * 
 * use Modules\Booking\App\Http\Controllers\BookingController;

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});
 */