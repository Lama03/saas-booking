<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\Api\UserController;

use Modules\User\Models\User;

use Modules\Tenant\Models\Tenant;

use Illuminate\Http\Request;


/**
 * Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class)->names('user');
});
 */


Route::post('/register', function (Request $request) {

    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'slug' => 'unique:tenants',
    ], [
        'email.unique' => 'This email is already registered.',
        'slug.unique' => 'This business name is already in use.',
    ]);

    $tenant = Tenant::create([
        'name' => $request->slug,
        'slug' => Str::slug($request->slug),
        'businessType' => $request->businessType,
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        "tenant_id" => $tenant->id,
        'role' => "tenant_admin",
        'password' => Hash::make($request->password),
    ]);


    return response()->json([
        'message' => 'Registeration is successful',
        'token' => $user->createToken('auth_token')->plainTextToken,
    ]);
});


Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'remember' => 'nullable|boolean',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->boolean('remember');

    if (!Auth::attempt($credentials, $remember)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $user = Auth::user();

    return response()->json([
        'token' => $user->createToken('auth_token')->plainTextToken,
        'user' => $user,
    ]);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'role:super_admin'])->get('/super-admin/dashboard-data', function () {
    return response()->json(['message' => 'Super admin dashboard data']);
});

Route::middleware(['auth:sanctum', 'role:tenant_admin'])->get('/tenant-admin/dashboard-data', function () {
    return response()->json(['message' => 'Tenant admin dashboard data']);
});