<?php

use Illuminate\Support\Facades\Route;
use Modules\Service\App\Http\Controllers\Api\ServiceController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('services', ServiceController::class)->names('service');
});


Route::prefix('v1')->group(callback: function () {
    Route::get('/staff/{id}', [ServiceController::class, 'showStaffList']);
});