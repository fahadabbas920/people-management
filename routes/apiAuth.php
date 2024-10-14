<?php

use App\Http\Controllers\Auth\ApiAuthenticatedSessionController;


// API routes for authentication
Route::prefix('api')->group(function () {
    Route::post('login', [ApiAuthenticatedSessionController::class, 'apiLogin']);
    // Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ApiAuthenticatedSessionController::class, 'apiLogout']);
    // });
});