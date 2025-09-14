<?php

use Illuminate\Support\Facades\Route;
use Modules\Tenant\App\Http\Controllers\Api\TenantController;


Route::get('/tenants/{slug}', [TenantController::class, 'showBySlug']);
Route::get('/tenants/{tenantId}/services', [TenantController::class, 'services']);

Route::get('/tenants/{tenantId}/theme', [TenantController::class, 'getTheme']);


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('tenants', TenantController::class)->names('tenant');
    Route::get('/tenants/{tenantId}/settings', [TenantController::class, 'settings']);
    Route::middleware('auth:sanctum')->post('/tenant-settings/{tenantId}', [TenantController::class, 'updateSettings']);
});



